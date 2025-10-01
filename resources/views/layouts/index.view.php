<?php require __DIR__ . '/../partials/head.php'; ?>
<header>
    <h1>Georg's Advent of Code 'advent'ure</h1>
</header>
<main>
    <h2>Years</h2>
    <ul>
<?php foreach($index as $ind => $title) { ?>
        <li>
            <a href="<?=($base_href ?? '').($index_base ?? '').($ind)?>"><?="$title - $ind"?></a>
        </li>
<?php } ?>
    </ul>
</main>

<?php require __DIR__ . '/../partials/foot.php' ?>