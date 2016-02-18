<?php $this->load_fragment('skeleton_template/header', ['title' => __('Events')]); ?>
<?php if (!$is_ajax): ?>
<article class="page open events-page full">
<?php endif; ?>
<div class="text-center">
    <h1><?= __('Events') ?></h1>
    <div class="row padded">
        <?php foreach ($events_data as $event): ?>
            <?php if ($event['template'] == 'category'): ?>
                <div class="col4 some-top-margin">
                    <span class="event-icon"><i class="<?= $event['data']['icon'] ?>"></i></span>
                    <h2>
                        <a class="underlined" href="<?= locale_base_url() . substr($event['path'], 1, -6) ?>">
                            <?= $event['data']['name'] ?>
                        </a>
                    </h2>
                    <p class="lead"><?= $event['data']['tagline'] ?>&nbsp;</p>
                    <p><?= $event['data']['description'] ?>&nbsp;</p>
                    <a class="btn" href="<?= locale_base_url() . substr($event['path'], 1, -6) ?>">
                        View all events
                    </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php if (!$is_ajax): ?>
</article>
<?php endif; ?>
<?php $this->load_fragment('skeleton_template/footer'); ?>
