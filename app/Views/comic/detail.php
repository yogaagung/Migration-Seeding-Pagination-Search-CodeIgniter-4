<?php echo $this->extend('template/layout'); ?>

<?php echo $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Detail Comic</h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?php echo $comic['cover']; ?>" class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $comic['title']; ?></h5>
                            <p class="card-text"><strong>Author : <?php echo $comic['author']; ?></strong></p>
                            <p class="card-text"><small class="text-muted"><strong>Publisher : <?php echo $comic['publisher']; ?></strong></small></p>

                            <a href="/comic/edit/<?php echo $comic['slug']; ?>" class="btn btn-warning">Edit</a>

                            <form action="/comic/<?php echo $comic['id']; ?>" method="post" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            <br><br>

                            <a href="/comic">Back To List</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>