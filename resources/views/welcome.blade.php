@include('layout.header')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Include any additional stylesheets or scripts here -->
</head>

<body style=" background-size: cover;">
    <div style="
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        opacity: 1;
        background-color:papayawhip; 
        filter: ightness(0.9);
        background-size: cover;
        box-shadow: inset 0 4px 15px rgba(0, 0, 0, 0.9);">
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="mt-5">Link's list</h1>
                <div class="list-group">
                    <a href="/filmout/oldFilms" class="list-group-item list-group-item-action list-group-item-info">Old films</a>
                    <a href="/filmout/newFilms" class="list-group-item list-group-item-action list-group-item-info">New films</a>
                    <a href="/filmout/films" class="list-group-item list-group-item-action list-group-item-info">All films</a>
                    <a href="/filmout/countFilms" class="list-group-item list-group-item-action list-group-item-info">Count films</a>
                </div>
            </div>
            <div class="col">
                <h1 class="mt-5">¡Create a film!</h1>
                <form action="{{ route('createFilm') }}" method="post">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input id="name" type="text" name="name" class="form-control" style="background-Color: #bee5eb">
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Year:</label>
                        <input type="number" name="year" class="form-control" style="background-Color: #bee5eb">
                    </div>

                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre:</label>
                        <input type="text" name="genre" class="form-control" style="background-Color: #bee5eb">
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label">Country:</label>
                        <input type="text" name="country" class="form-control" style="background-Color: #bee5eb">
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration:</label>
                        <input type="number" name="duration" class="form-control" style="background-Color: #bee5eb">
                    </div>

                    <div class="mb-3">
                        <label for="img_url" class="form-label">Image URL:</label>
                        <input type="text" name="img_url" class="form-control" style="background-Color: #bee5eb">
                    </div>

                    <div class="mb-3">
                        <input type="submit" name="sendButton" value="Submit" class="btn" style="background-Color: #bee5eb">
                    </div>
                </form>
            </div>
            <!-- Add Bootstrap JS and Popper.js (required for Bootstrap) -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

            <!-- Include any additional HTML or Blade directives here -->
        </div>
        <div class="row">
            @if (!empty($error))
            <div class="col text-center">
                <div class="alert alert-danger">
                    <FONT style=" font-family:monospace; font-weight: bold; font-size: 1.5em;" COLOR="red">{{ $error }}</FONT>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>
@include('layout.footer')