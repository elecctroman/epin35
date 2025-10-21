INSERT INTO users (email, password_hash, name, phone, role) VALUES
('admin@example.com', '$2y$12$JREbe5ak6OZN2VFobjHR5utvWNmluhJSWaSGWKV32MaxRXxR0cgNu', 'Maxi Admin', '+90 850 000 00 00', 'admin'),
('user@example.com', '$2y$12$kQwtC9WXCaJLSipjys1n3ec5ruG7df8vQ88qRHfOLzS92gL4t4Kdy', 'Maxi Kullanıcı', '+90 850 000 00 01', 'user');

INSERT INTO categories (name, slug, sort) VALUES
('Oyun Paraları', 'oyun-paralari', 1),
('Lisans Anahtarları', 'lisans-anahtarlari', 2),
('Hediye Kartları', 'hediye-kartlari', 3);

INSERT INTO products (category_id, name, slug, description, cover, is_active) VALUES
(1, 'Valorant VP 125', 'valorant-vp-125', 'Valorant hesabınızı güçlendiren VP paketleri.', '', 1),
(1, 'PUBG Mobile UC 660', 'pubg-uc-660', 'PUBG Mobile için UC yükleme paketi.', '', 1),
(2, 'Windows 11 Pro', 'windows-11-pro', 'Kurumsal özelliklerle Windows 11 Pro lisansı.', '', 1);

INSERT INTO product_variations (product_id, title, price, old_price, stock, sku) VALUES
(1, '125 VP', 89.90, 99.90, 150, 'VAL-125'),
(1, '325 VP', 219.90, 239.90, 100, 'VAL-325'),
(2, '660 UC', 149.90, 169.90, 120, 'PUB-660'),
(3, 'Tek PC Lisans', 499.90, 699.90, 50, 'WIN-1PC');

INSERT INTO vendors (name, rating, sales_count) VALUES
('NeoGames', 4.85, 1250),
('CodeSmith', 4.90, 980),
('DigitalHive', 4.72, 1430);

INSERT INTO banners (title, image, url, sort, is_active) VALUES
('Kış İndirimleri Başladı', '/assets/svg/placeholder-product.svg', '#', 1, 1),
('Anında Teslim Valorant Paketleri', '/assets/svg/placeholder-product.svg', '#', 2, 1);

INSERT INTO stock_items (variation_id, code_hash, code_plain_encrypted, is_sold)
VALUES
(1, SHA2('VAL-125-001', 256), 'VAL-125-001', 0),
(1, SHA2('VAL-125-002', 256), 'VAL-125-002', 0),
(2, SHA2('VAL-325-001', 256), 'VAL-325-001', 0),
(3, SHA2('PUB-660-001', 256), 'PUB-660-001', 0),
(4, SHA2('WIN-1PC-001', 256), 'WIN-1PC-001', 0);
