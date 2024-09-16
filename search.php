<?php
include 'header.php';
include 'connection.php';

$apiKey = 'bb43e11dcb35b146bb8862147a033de3';
$itemsPerPage = 20; // Define how many items per page

// Get the current page number from URL, default to 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1); // Ensure the page number is at least 1

// Get the search query from URL
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Define the endpoints with search query if present
$endpoints = [
    'searchMovies' => "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=" . urlencode($searchQuery),
    'searchTvShows' => "https://api.themoviedb.org/3/search/tv?api_key=$apiKey&query=" . urlencode($searchQuery),
];

// Fetch data
$data = [];
foreach ($endpoints as $key => $url) {
    $response = file_get_contents($url);
    $data[$key] = json_decode($response, true);
}

// Combine results from movies and TV shows
$combinedData = array_merge(
    $data['searchMovies']['results'] ?? [],
    $data['searchTvShows']['results'] ?? []
);

// Paginate results
$totalItems = count($combinedData);
$offset = ($page - 1) * $itemsPerPage;
$paginatedData = array_slice($combinedData, $offset, $itemsPerPage);

// Pagination logic
$previousPage = $page > 1 ? $page - 1 : null;
$nextPage = ($page * $itemsPerPage < $totalItems) ? $page + 1 : null;

// Calculate range of page numbers to display (show 5 page numbers)
$totalPages = ceil($totalItems / $itemsPerPage);
$startPage = max(1, $page - 2);
$endPage = min($totalPages, $page + 2);

?>

<!-- Search Form -->
<div class="container">
    <br><br>
    <form class="d-flex mb-4" method="get" action="">
        <input class="form-control me-2" type="search" name="search" placeholder="Search movies or TV shows" aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
</div>

<div class="container">
    <?php if (empty($paginatedData)): ?>
        <p class="text-center">No results found.</p>
    <?php else: ?>
        <!-- Display Combined Data -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4">
            <?php foreach ($paginatedData as $item): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="https://image.tmdb.org/t/p/w500<?php echo $item['poster_path']; ?>" class="card-img-top" alt="<?php echo $item['title'] ?? $item['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['title'] ?? $item['name']; ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    
        <!-- Pagination Links --><br>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
                <?php if ($previousPage): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $previousPage; ?>&search=<?php echo urlencode($searchQuery); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchQuery); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($nextPage): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $nextPage; ?>&search=<?php echo urlencode($searchQuery); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
