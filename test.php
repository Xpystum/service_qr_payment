<?php if ($options): ?>
    <div class="buttons">
        <?php $accum = true ?>
        <?php foreach ($options as $option): ?>
            <button id="select-option-<?=$option['id'];?>" class="option-button trans04 <?php echo $accum ? "active" : ""; ?>" onclick="changeOption(<?=$option['id'];?>)"
                    data-id="<?= $option['id']; ?>"
                    data-link-digisiller="<?= $option['link_digiseller']; ?>"
                    data-price="<?= $option['price']; ?>">
                <p> <?= $option['name']; ?> </p>
                <p><?= $option['price']; ?> ₽</p>
            </button>
            <?php $accum = false ?>
        <?php endforeach; ?>
    </div>
    <input type="hidden" id="option_value">
<?php endif; ?>
