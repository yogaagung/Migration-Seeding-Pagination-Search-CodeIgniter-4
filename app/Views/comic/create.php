<?php echo $this->extend('template/layout'); ?>

<?php echo $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Form Add Comic</h2>

            <form action="/comic/save" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?php echo ($validation->hasError('title')) ? 'is-invalid' : ''; ?>" id="title" name="title" autofocus value="<?php echo old('title'); ?>">
                        <div class="invalid-feedback">
                            <?php echo $validation->getError('title'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="author" class="col-sm-2 col-form-label">Author</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?php echo ($validation->hasError('author')) ? 'is-invalid' : ''; ?>" id="author" name="author" value="<?php echo old('author'); ?>">
                        <div class="invalid-feedback">
                            <?php echo $validation->getError('author'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="publisher" class="col-sm-2 col-form-label">Publisher</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?php echo ($validation->hasError('publisher')) ? 'is-invalid' : ''; ?>" id="publisher" name="publisher" value="<?php echo old('publisher'); ?>">
                        <div class="invalid-feedback">
                            <?php echo $validation->getError('publisher'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="cover" class="col-sm-2 col-form-label">Cover</label>
                    <div class="col-sm-2">
                        <img src="/img/default.png" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?php echo ($validation->hasError('cover')) ? 'is-invalid' : ''; ?>" id="cover" name="cover" onchange="previewImg()">
                            <div class="invalid-feedback">
                                <?php echo $validation->getError('cover'); ?>
                            </div>
                            <label class="custom-file-label" for="Cover">Browse Picture</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>