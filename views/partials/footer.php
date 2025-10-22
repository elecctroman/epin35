<footer class="footer">
  <div class="container footer-grid">
    <div class="footer-brand">
      <div class="brand"><span class="brand-logo">M</span><span>MaxiStore</span></div>
      <p>Oyun para birimlerinden kurumsal lisans paketlerine kadar binlerce dijital ürün tek panelde. Maksimum güven, maksimum hız.</p>
      <div class="certificate-list">
        <span class="chip">PCI Mock</span>
        <span class="chip">ISO27001 Süreçleri</span>
        <span class="chip">FraudShield™</span>
      </div>
    </div>
    <div>
      <h4>Kurumsal</h4>
      <ul class="link-list">
        <li><a href="#">Hakkımızda</a></li>
        <li><a href="#">Gizlilik Politikası</a></li>
        <li><a href="#">KVKK Aydınlatması</a></li>
        <li><a href="#">İletişim</a></li>
      </ul>
    </div>
    <div>
      <h4>Popüler Ürünler</h4>
      <ul class="link-list">
        <li><a href="<?= \Core\Helpers::baseUrl('kategori/oyun-paralari') ?>">Valorant VP Paketleri</a></li>
        <li><a href="<?= \Core\Helpers::baseUrl('kategori/hediye-kartlari') ?>">Steam &amp; Netflix Kartları</a></li>
        <li><a href="<?= \Core\Helpers::baseUrl('kategori/lisans-anahtarlari') ?>">Windows &amp; Office Lisansları</a></li>
        <li><a href="#">Popüler Hesap Satışları</a></li>
      </ul>
    </div>
    <div>
      <h4>Haber Bülteni</h4>
      <form class="newsletter" action="#" method="post">
        <label for="newsletter-email">Haftalık fırsat ve stok bildirimleri</label>
        <div class="newsletter-control">
          <input type="email" id="newsletter-email" placeholder="ornek@mail.com" required>
          <button type="submit">Kaydol</button>
        </div>
      </form>
      <div class="social-links" aria-label="Sosyal medya">
        <a href="#" aria-label="Twitter">Tw</a>
        <a href="#" aria-label="YouTube">Yt</a>
        <a href="#" aria-label="Instagram">Ig</a>
      </div>
    </div>
  </div>
  <div class="container footer-bottom">
    <div class="payment-icons">
      <span>Iyzico Mock</span>
      <span>Papara Mock</span>
      <span>Shopier Mock</span>
    </div>
    <small>© <?= date('Y') ?> MaxiStore. Tüm hakları saklıdır. Türkiye'de barındırılan güvenli sunucularda çalışır.</small>
  </div>
</footer>
