
    <?php
    include 'connection.php';
    include 'header.php';

    $apiKey = 'bb43e11dcb35b146bb8862147a033de3';
    $apiUrl = 'https://api.themoviedb.org/3/movie/popular?api_key=' . $apiKey;

    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    // Base URL for TMDb images
    $imageBaseUrl = 'https://image.tmdb.org/t/p/w500';
    ?>

    <div class="container-fluid mt-2" style="padding: 30px;">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            <?php foreach ($data['results'] as $movie): ?>
                <div class="col" style="text-align: center;">
                    <div class="card h-100">
                        <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal<?php echo $movie['id']; ?>">
                            <img src='<?php echo $imageBaseUrl . htmlspecialchars($movie['poster_path']); ?>' class="card-img-top img-button" alt='<?php echo htmlspecialchars($movie['title']); ?>' />
                        </a>
                        <div class="card-body">
                            <h6 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h6>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success" style="--clr: #00ad54;">
                                <div class="button-content">
                                <i style=" padding-right:10px;" class="fa-solid fa-check-to-slot"></i>
                                    <small class="button__text" style=" padding: unset;">Add list</small>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal for each movie -->
                <div class="modal fade" id="modal<?php echo $movie['id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $movie['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?php echo $movie['id']; ?>"><?php echo htmlspecialchars($movie['title']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src='<?php echo $imageBaseUrl . htmlspecialchars($movie['poster_path']); ?>' class="img-fluid" alt='<?php echo htmlspecialchars($movie['title']); ?>' />
                                <p><?php echo htmlspecialchars($movie['overview']); ?></p>
                            </div>
                            <div class="modal-footer">
                                <form action="" method="get">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <a href="#" class="floating-button " data-bs-toggle="modal" data-bs-target="#myModal">
        
        <i class="fa-solid fa-list"></i>
    </a>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This is the content of the modal. You can place any text or HTML here.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php include 'footer.php'; ?>


