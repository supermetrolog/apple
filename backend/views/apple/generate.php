 <div class="col-lg-12 m-0">
     <div class="row">
         <? foreach ($apples as $apple) : ?>
             <? if (!$apple->status) : ?>
                 <div class="col-lg-1 apple-item <?= $apple->getColorClass() ?>">
                     <i class="fas fa-apple-alt apple-icon"></i>
                     <i title="Уронить" class="fas fa-arrow-down drop-apple" data-apple-id="<?= $apple->id ?>"></i>
                 </div>
             <? endif; ?>
         <? endforeach; ?>
     </div>
 </div>
 <hr>
 <div class="col-lg-12">
     <div class="row">
         <? foreach ($apples as $apple) : ?>
             <? if ($apple->status) : ?>
                 <div class="col-lg-1 apple-item <?= $apple->getColorClass() ?>">
                     <input class="eaten-percent" type="text">
                     <i title="Съесть" class="fas fa-check eat-apple" data-apple-id="<?= $apple->id ?>"></i>
                     <i class="fas fa-apple-alt apple-icon" style="opacity: <?= $apple->getEatenPercent() ?>%;"></i>
                     <strong class="text-primary"><?= $apple->getEatenPercent() ?>%</strong>
                 </div>
             <? endif; ?>
         <? endforeach; ?>
     </div>
 </div>