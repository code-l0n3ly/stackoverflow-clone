<?php
// Create an array of data
$data = array("item 1", "item 2", "item 3", "item 4", "item 5", "item 6", "item 7", "item 8", "item 9", "item 10");

// Determine the number of rows per page
$rows_per_page = 3;

// Determine the total number of rows
$total_rows = count($data);

// Determine the number of pages
$num_pages = ceil($total_rows / $rows_per_page);

// Determine the current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}

// Calculate the starting row
$start = ($page - 1) * $rows_per_page;

// Create a new array of data for the current page
$current_page_data = array_slice($data, $start, $rows_per_page);

// Display the data for the current page
foreach ($current_page_data as $item) {
  echo $item . "<br>";
}

// Create the pagination links
echo "<p>";
if ($page > 1) {
  echo "<a href='pagination.php?page=" . ($page - 1) . "'>Previous</a> ";
}
for ($i = 1; $i <= $num_pages; $i++) {
  echo "<a href='pagination.php?page=$i'>$i</a> ";
}
if ($page < $num_pages) {
  echo "<a href='pagination.php?page=" . ($page + 1) . "'>Next</a> ";
}
echo "</p>";
?>
