<div class="container my-5">
    <div class="product card border-0 shadow-sm p-4 rounded-lg">
        <div class="row align-items-center">
            <div class="col-lg-4 text-center mb-3 mb-lg-0">
                <div class="card__image bg-light p-4 rounded-lg d-flex align-items-center justify-content-center" style="min-height: 200px;">
                    <?php if (!empty($product['picture']) && file_exists(FCPATH . 'assets/images/product/' . $product['picture'])) { ?>
                        <img src="<?= base_url('assets/images/product/' . $product['picture']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    <?php } else { ?>
                        <i class="fas fa-wifi text-primary" style="font-size: 80px;"></i>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="product-text">
                    <h2 class="font-weight-bold text-dark mb-2">
                        <?= htmlspecialchars($product['name']) ?>
                    </h2>
                    <p class="lead text-muted mb-4"><?= htmlspecialchars($product['remark']) ?></p>
                    <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($company['whatsapp']); ?>&text=Halo%20kami%20tertarik%20dengan%20layanan%20<?= urlencode($product['name']) ?>" target="_blank" class="btn btn-success btn-lg font-weight-bold px-4 shadow-sm">
                        <i class="fab fa-whatsapp mr-2"></i> Kontak Kami Via WhatsApp
                    </a>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="product-description text-secondary">
            <?= $product['description'] ?>
        </div>
    </div>
</div>