<?php
namespace Controllers\Admin;

use Core\Auth;
use Core\Csrf;
use Core\Helpers;
use Core\View;
use Models\Ticket;

class TicketsController
{
    public function index(): void
    {
        Auth::requireAdmin();
        $ticketModel = new Ticket();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $filters = [
            'status' => $_GET['status'] ?? '',
            'search' => trim($_GET['q'] ?? ''),
        ];
        $total = $ticketModel->count($filters);
        $tickets = $ticketModel->paginate($filters, $perPage, ($page - 1) * $perPage);
        View::make('admin/tickets/index', [
            'tickets' => $tickets,
            'filters' => $filters,
            'pagination' => Helpers::pagination($total, $perPage, $page),
        ]);
    }

    public function show(int $id): void
    {
        Auth::requireAdmin();
        $ticketModel = new Ticket();
        $ticket = $ticketModel->find($id);
        if (!$ticket) {
            http_response_code(404);
            exit('Destek talebi bulunamadı');
        }
        View::make('admin/tickets/show', [
            'ticket' => $ticket,
        ]);
    }

    public function reply(int $id): void
    {
        Auth::requireAdmin();
        if (!Csrf::validate($_POST['_token'] ?? '')) {
            http_response_code(419);
            exit('CSRF token mismatch');
        }
        $body = trim($_POST['body'] ?? '');
        if ($body === '') {
            Helpers::setFlash('admin', 'Mesaj boş olamaz.', 'error');
            Helpers::redirect(Helpers::baseUrl('admin/tickets/' . $id));
        }
        $ticketModel = new Ticket();
        $ticketModel->addMessage($id, Auth::user()['id'] ?? null, $body);
        if (!empty($_POST['status'])) {
            $ticketModel->updateStatus($id, $_POST['status']);
        }
        Helpers::setFlash('admin', 'Yanıt gönderildi.', 'success');
        Helpers::redirect(Helpers::baseUrl('admin/tickets/' . $id));
    }
}
