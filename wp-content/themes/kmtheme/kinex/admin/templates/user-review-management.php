<?php
/**
 * Date: 05/10/17
 * Time: 1:46 PM
 */

$class = "";

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {

    if ($this->km_delete_row_by_id('review_raiting', $_GET['id'])) {
        $class = 'success';
        $message = "Review  Deleted Successfully.";
    }
}
if (isset($_GET['msg']) AND $_GET['msg'] == 'true') {
    $class = 'success';
    $message = "Review Deleted Successfully.";
}


?>


<div class="wrap">
    <?php
    if (isset($message) AND !empty($message)) {
        ?>

        <div class="alert <?php echo $class ?>" role="alert">
            <?php echo $message; ?>
        </div>

        <?php
    }
    ?>

    <div class="col-md-12">
        <?php if (isset($_GET['action']) && $_GET['action'] == 'view') { ?>
            <div class="table-backend">
                <div id="icon-users" class="icon32"></div>
                <?php
                if (isset($_GET['id'])) {
                    $review = $this->km_get_row_by_id($_GET['id']);
                } else {
                    $review = '';
                }


                ?>
                <h2>View User Review <a class="pull-right"
                                        href="<?php echo KM_REVIEW_URL . '?page=km-review-management';
                                        ?>">Back To
                        List</a></h2>
                <table>
                    <tbody>
                    <?php if ($review): ?>
                        <tr>
                            <th>ID</th>
                            <td><?php echo $review->id; ?></td>
                        </tr>
                        <tr>
                            <th>User Name</th>
                            <td><?php echo get_userdata($review->user_id)->display_name; ?></td>
                        </tr>
                        <tr>
                            <th>Tasker Name</th>
                            <td><?php echo get_userdata($review->tasker_id)->display_name; ?></td>
                        </tr>
                        <tr>
                            <th>Rating</th>
                            <td><?php echo $review->rating; ?> Star</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?php echo $review->review_description; ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td>No Review Found</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>

            <div id="icon-users" class="icon32"></div>
            <h2>Review Management</h2>


            <form id="events-filter" method="get">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>

                <?php
                if (class_exists("KM_Review_Tables")) {
                    $poll_list = new KM_Review_Tables();
                    $poll_list->prepare_items();
                    $poll_list->display();
                }
                ?>
            </form>

        <?php } ?>

    </div>
</div>
<style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content, #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }
        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }
        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 35px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
</style>