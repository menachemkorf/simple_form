<?php
    $auth_error = false;
    $success = false;
    if(!empty($response)) {
        if($response['type'] == 'auth' && $response['status'] == 'error') {
            $auth_error = true;
        }

        if($response['status'] == 'success') {
            $success = true;
        }
    }
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-6">

            <?php if($success) { ?>
                <div class="alert alert-success" role="alert">
                    <?= $response['message'] ?>
                </div>
            <?php } ?>

            <div class="card border-secondary mb-3 row">
                <h1 class="card-header">Simple Form</h1>
                <div class="card-body text-secondary">
                    <form id="form" action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input
                                type="text"
                                class="form-control <?= $auth_error ? 'is-invalid' : '' ?>"
                                id="username"
                                name="username"
                                placeholder="name@example.com">

                            <div class="invalid-feedback">
                                <?= $auth_error ? $response['message'] : '' ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" placeholder="Leave a comment here" id="message" name="message" style="height: 100px"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attchemant</label>
                            <input class="form-control" type="file" id="attachment" name="attachment">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="">
                            <button id="submit" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
