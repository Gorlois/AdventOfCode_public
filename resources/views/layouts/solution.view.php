<?php require __DIR__ . '/../partials/head.php'; ?>
<main>
    <form action="/year/<?=$year?>/day/solve?id=<?=$dayId?>" method="post" enctype="multipart/form-data">
        <label for="puzzle_input">Please upload the AOC provided puzzle input as a .txt file here</label><br>
        <input type="hidden" name="MAX_FILE_SIZE" value="300000">
        <input type="file" name="puzzle_in" id="puzzle_input"><br><br>
        <p>and select the part you want to solve</p>
        <input type="radio" name="part" id="r_p1" value="1" checked>
        <label for="r_p1">Part 1</label>
        <input type="radio" name="part" id="r_p2" value="2">
        <label for="r_p2">Part 2</label>
        <br><br>
        <input type="submit" value="Solve">
    </form>

    <br><br>

    <div>
        <h2>Solution</h2>
        <p><?= nl2br(htmlspecialchars($solution)) ?></p>
    </div>
</main>

<?php require __DIR__ . '/../partials/foot.php' ?>