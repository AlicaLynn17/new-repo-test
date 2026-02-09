<?php
/**
 * Shuffle an array and return a new shuffled copy
 */
function shuffle_array(array $array): array
{
    $copy = $array;
    shuffle($copy);
    return $copy;
}

/**
 * Calculate the total ASCII value of all characters in a string
 */
function ascii_total(string $value): int
{
    $total = 0;
    $length = strlen($value);

    for ($i = 0; $i < $length; $i++) {
        $total += ord($value[$i]);
    }

    return $total;
}

$shuffledPairs = [];
$alphabeticalPairs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstNames = [];
    $lastNames  = [];

    for ($i = 0; $i < 10; $i++) {
        $firstNames[] = trim($_POST['first'][$i] ?? '');
        $lastNames[]  = trim($_POST['last'][$i] ?? '');
    }

    $shuffledFirstNames = shuffle_array($firstNames);
    $shuffledLastNames  = shuffle_array($lastNames);

    for ($i = 0; $i < 10; $i++) {
        $pair = [
            'first' => $shuffledFirstNames[$i],
            'last'  => $shuffledLastNames[$i],
        ];

        $shuffledPairs[] = $pair;

        if (strcasecmp($pair['first'], $pair['last']) <= 0) {
            $alphabeticalPairs[] = $pair;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exercise 1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 10px;
        }
        input {
            margin-right: 8px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<h1>Exercise 1</h1>

<form method="post">
    <h2>Enter 10 Names</h2>

    <?php for ($i = 0; $i < 10; $i++): ?>
        <div>
            <input
                type="text"
                name="first[]"
                placeholder="First Name"
                required
            >
            <input
                type="text"
                name="last[]"
                placeholder="Last Name"
                required
            >
        </div>
    <?php endfor; ?>

    <br>
    <button type="submit">Submit</button>
</form>

<?php if (!empty($shuffledPairs)): ?>

    <h2>Shuffled First and Last Names</h2>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
        <?php foreach ($shuffledPairs as $pair): ?>
            <tr>
                <td><?= htmlspecialchars($pair['first']) ?></td>
                <td><?= htmlspecialchars($pair['last']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Alphabetical (First ≤ Last)</h2>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
        <?php foreach ($alphabeticalPairs as $pair): ?>
            <tr>
                <td><?= htmlspecialchars($pair['first']) ?></td>
                <td><?= htmlspecialchars($pair['last']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Last Names and ASCII Totals</h2>
    <table>
        <tr>
            <th>Last Name</th>
            <th>ASCII Total</th>
        </tr>
        <?php foreach ($shuffledPairs as $pair): ?>
            <tr>
                <td><?= htmlspecialchars($pair['last']) ?></td>
                <td><?= ascii_total($pair['last']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php endif; ?>

</body>
</html>
