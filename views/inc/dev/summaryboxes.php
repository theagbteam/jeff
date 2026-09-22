
<?php  if ($page_name=="dashboard") :  ?>
                <div class="row">

                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

                        <a
                            href="index.php?action=totalrequest"
                            style="text-decoration:none; width:100%;"
                        >

                            <div class="card">

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-9">

                                            <div
                                                class="d-flex align-items-center align-self-start"
                                            >

                                                <h3
                                                    class="mb-0 dashboard-counter"
                                                    data-target="<?= (int)$totalrequests ?>"
                                                >
                                                    0
                                                </h3>

                                            </div>

                                        </div>

                                        <div class="col-3"></div>

                                    </div>

                                    <h6 class="text-muted font-weight-normal">
                                        Pending Requests
                                    </h6>

                                </div>

                            </div>

                        </a>

                    </div>

                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

                        <a
                            href="index.php?action=users"
                            style="text-decoration:none; width:100%;"
                        >

                            <div class="card">

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-9">

                                            <div
                                                class="d-flex align-items-center align-self-start"
                                            >

                                                <h3
                                                    class="mb-0 dashboard-counter"
                                                    data-target="<?= (int)$totaladmin ?>"
                                                >
                                                    0
                                                </h3>

                                            </div>

                                        </div>

                                        <div class="col-3"></div>

                                    </div>

                                    <h6 class="text-muted font-weight-normal">
                                        Total Administrator
                                    </h6>

                                </div>

                            </div>

                        </a>

                    </div>

                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

                        <a
                            href="index.php?action=users"
                            style="text-decoration:none; width:100%;"
                        >

                            <div class="card">

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-9">

                                            <div
                                                class="d-flex align-items-center align-self-start"
                                            >

                                                <h3
                                                    class="mb-0 dashboard-counter"
                                                    data-target="<?= (int)$totalsupervisor ?>"
                                                >
                                                    0
                                                </h3>

                                            </div>

                                        </div>

                                        <div class="col-3"></div>

                                    </div>

                                    <h6 class="text-muted font-weight-normal">
                                        Total Supervisors
                                    </h6>

                                </div>

                            </div>

                        </a>

                    </div>

                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

                        <a
                            href="index.php?action=users"
                            style="text-decoration:none; width:100%;"
                        >

                            <div class="card">

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-9">

                                            <div
                                                class="d-flex align-items-center align-self-start"
                                            >

                                                <h3
                                                    class="mb-0 dashboard-counter"
                                                    data-target="<?= (int)$totalreporters?>"
                                                >
                                                    0
                                                </h3>

                                            </div>

                                        </div>

                                        <div class="col-3"></div>

                                    </div>

                                    <h6 class="text-muted font-weight-normal">
                                        Total Reporters
                                    </h6>

                                </div>

                            </div>

                        </a>

                    </div>

                </div><?php endif;  ?>