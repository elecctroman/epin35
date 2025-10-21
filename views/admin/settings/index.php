<?php
use Core\Helpers;
$title = 'Genel Ayarlar';
ob_start();
?>
<section class="card">
  <header class="card-title">
    <div>
      <h2>Platform Ayarları</h2>
      <p class="subtitle">Marka, iletişim ve ödeme yapılandırmalarını yönetin.</p>
    </div>
  </header>
  <form class="settings-grid" action="<?= Helpers::baseUrl('admin/settings') ?>" method="post">
    <?= Helpers::csrfField() ?>
    <section class="settings-section">
      <h3>Marka Kimliği</h3>
      <div class="form-field">
        <label>Marka Adı</label>
        <input type="text" name="branding[name]" value="<?= Helpers::e($branding['name'] ?? 'MaxiStore') ?>">
      </div>
      <div class="form-field">
        <label>Üst Başlık</label>
        <input type="text" name="branding[headline]" value="<?= Helpers::e($branding['headline'] ?? 'Dijital Lisans Marketi') ?>">
      </div>
      <div class="form-field">
        <label>Ana Renk</label>
        <input type="color" name="branding[primary_color]" value="<?= Helpers::e($branding['primary_color'] ?? '#3b82f6') ?>">
      </div>
    </section>

    <section class="settings-section">
      <h3>E-posta SMTP</h3>
      <div class="form-field">
        <label>Sunucu</label>
        <input type="text" name="mail[host]" value="<?= Helpers::e($mail['host'] ?? '') ?>">
      </div>
      <div class="form-field">
        <label>Port</label>
        <input type="number" name="mail[port]" value="<?= Helpers::e($mail['port'] ?? 587) ?>">
      </div>
      <div class="form-field">
        <label>Kullanıcı Adı</label>
        <input type="text" name="mail[user]" value="<?= Helpers::e($mail['user'] ?? '') ?>">
      </div>
      <div class="form-field">
        <label>Parola</label>
        <input type="password" name="mail[password]" value="<?= Helpers::e($mail['password'] ?? '') ?>">
      </div>
    </section>

    <section class="settings-section">
      <h3>Ödeme Sağlayıcıları</h3>
      <div class="form-field">
        <label>Iyzico Key</label>
        <input type="text" name="payment[iyzico_key]" value="<?= Helpers::e($payment['iyzico_key'] ?? '') ?>">
      </div>
      <div class="form-field">
        <label>Papara Merchant</label>
        <input type="text" name="payment[papara_merchant]" value="<?= Helpers::e($payment['papara_merchant'] ?? '') ?>">
      </div>
      <div class="form-field">
        <label>Shopier API</label>
        <input type="text" name="payment[shopier_api]" value="<?= Helpers::e($payment['shopier_api'] ?? '') ?>">
      </div>
    </section>

    <section class="settings-section">
      <h3>Ödeme Adımları</h3>
      <div class="form-field">
        <label>Kargo Mesajı</label>
        <input type="text" name="checkout[delivery_notice]" value="<?= Helpers::e($checkout['delivery_notice'] ?? 'Kodlarınız ödeme sonrası anında hesabınıza tanımlanır.') ?>">
      </div>
      <div class="form-field">
        <label>İade Politikası Linki</label>
        <input type="text" name="checkout[refund_policy_url]" value="<?= Helpers::e($checkout['refund_policy_url'] ?? '') ?>">
      </div>
    </section>

    <section class="settings-section">
      <h3>Güvenlik</h3>
      <div class="form-field">
        <label>İki Aşamalı Doğrulama</label>
        <select name="security[require_2fa]">
          <option value="0" <?= empty($security['require_2fa']) ? 'selected' : '' ?>>Opsiyonel</option>
          <option value="1" <?= !empty($security['require_2fa']) ? 'selected' : '' ?>>Zorunlu</option>
        </select>
      </div>
      <div class="form-field">
        <label>Giriş Sınırı (deneme)</label>
        <input type="number" name="security[login_rate_limit]" value="<?= Helpers::e($security['login_rate_limit'] ?? 5) ?>">
      </div>
    </section>

    <div class="settings-submit">
      <button class="btn-primary" type="submit">Ayarları Kaydet</button>
    </div>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layouts/admin.php';
?>
