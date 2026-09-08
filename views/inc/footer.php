
            <footer class="footer">

                <div class="d-sm-flex justify-content-center justify-content-sm-between">

                    <span
                        style="text-decoration:none !important;"
                        class="text-muted text-center text-sm-left d-block d-sm-inline-block"
                    >

                        Copyright © <?= $company_copyright ?>

                        <a
                            href="<?= htmlspecialchars($company_copyrightlink) ?>"
                            target="_blank"
                        >

                            <?= htmlspecialchars($company_poweredby) ?>

                        </a>

                        All rights reserved.

                    </span>

                    <span
                        class="text-muted float-none float-sm-end d-block mt-1 mt-sm-0 text-center"
                    >

                        <?= $company_settings['company_appversion']  ?>

                        <i class="mdi mdi-heart text-danger"></i>

                    </span>

                </div>

            </footer>