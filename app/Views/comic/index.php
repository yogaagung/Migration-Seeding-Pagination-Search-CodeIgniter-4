<?php echo $this->extend('template/layout'); ?>

<?php echo $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <a href="/comic/create" class="btn btn-primary mt-3">Add Comic</a>
            <h1 class="mt-2">List Comic</h1>

            <?php if (session()->getFlashdata('message')) : ?>
                <div class="alert alert-primary" role="alert">
                    <?php echo session()->getFlashdata('message'); ?>
                </div>
            <?php endif; ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cover</th>
                        <th scope="col">Title</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($comic as $c) : ?>
                        <tr>
                            <th scope="row"><?php echo $i++; ?></th>
                            <td><img src="/img/<?php echo $c['cover']; ?>" alt="" class="cover"></td>
                            <td><?php echo $c['title']; ?></td>
                            <td>
                                <a href="/comic/<?php echo $c['slug']; ?>" class="btn btn-danger">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>