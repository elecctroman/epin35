# MaxiStore Dijital Ürün Platformu

MaxiStore, cPanel/Apache ortamlarında çalışmak üzere tasarlanmış modern bir dijital ürün (E-PIN / lisans) satış platformu iskeletidir. Proje saf PHP 8.2+, MySQL 8 ve Vanilla JS kullanılarak geliştirilmiştir.

## Özellikler

- Modüler dizin yapısı (config, core, models, controllers, views, assets)
- PDO ile güvenli veri erişimi, CSRF koruması ve temel doğrulama yardımcıları
- Route grupları ve middleware destekli hafif router
- Karanlık temalı müşteri arayüzü: ana sayfa, kategori, ürün, sepet, ödeme, hesap, destek, arama
- Yönetim paneli: dashboard, ürün, kategori, sipariş, kullanıcı, kupon, satıcı, ayar, banner, rapor ekranları
- Mock ödeme sürücüleri (manuel, iyzico, papara) ve stok kodu teslimatı
- MySQL şema ve örnek veri (database/schema.sql, database/seed.sql)
- Demo admin hesabı: `admin@example.com` / `Admin!234`
- 5 adet referans ekran görseli (`assets/img/demo-*.svg`)

## Kurulum

1. Depoyu cPanel hesabınıza veya yerel ortamınıza aktarın.
2. `config/config.php` içinde `base_url`, SMTP ve ödeme ayarlarını güncelleyin.
3. `.env` yerine ortam değişkenleri kullanın veya `config/db.php` içindeki varsayılanları düzenleyin.
4. MySQL üzerinde şema ve seed dosyalarını sırasıyla çalıştırın:

```sql
SOURCE database/schema.sql;
SOURCE database/seed.sql;
```

5. Apache sunucusunda `AllowOverride All` açık olduğundan emin olun. `.htaccess` dosyası ile tüm istekler `index.php`ye yönlendirilir.
6. `public_html` altında çalıştırıyorsanız, tüm dosyaları aynı dizine yükleyebilirsiniz.

## Test ve Araçlar

- Kod sözdizimi kontrolü: `find . -name "*.php" -not -path "./vendor/*" -exec php -l {} \;`
- Basit entegrasyon testi: `php tests/integration.php` (örnek betik eklemeniz gerekir)

## Güvenlik Notları

- Tüm kritik formlar CSRF tokenı içerir.
- Şifreler `password_hash` ile saklanır.
- Oturum çerezleri `HttpOnly`, `Secure` (HTTPS ortamında) ve `SameSite=Lax` olarak işaretlenir.
- Geliştirici modunda hata ayıklama açıktır; canlı ortamda `config/config.php` içinde `debug` alanını `false` yapın ve hata görüntülemeyi kapatın.

## Dosya Yapısı

```
config/          Yapılandırma dosyaları
core/            Router, View, Auth, Csrf, Validator, Helpers
models/          Veri katmanı (User, Product, Order vb.)
controllers/     MVC denetleyicileri
views/           Layout, müşteri ve admin şablonları
assets/          CSS, JS ve görseller
 database/       SQL şema ve örnek veri
```

## Lisans

Projede yer alan kod ve varlıkların tamamı MaxiStore için özgün olarak üretilmiştir. Kendi ticari projenize entegre ederken marka ve tasarım üzerinde değişiklik yapabilirsiniz.
