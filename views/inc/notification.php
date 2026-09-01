<?php if (!empty($_SESSION['msg']) && $_SESSION['msg_notification'] == 1): ?>

    <div id="adminNotification" class="admin-notification">

        <!-- Icon -->
        <div class="notification-icon">
            ✓
        </div>

        <!-- Message -->
        <div class="notification-content">

            <div class="notification-title">
                Notice
            </div>

            <div class="notification-message">
                <?= htmlspecialchars($_SESSION['msg'], ENT_QUOTES, 'UTF-8') ?>
            </div>

        </div>

        <!-- Close Button -->
        <button
            type="button"
            class="notification-close"
            onclick="closeNotification()"
            aria-label="Close notification"
        >
            &times;
        </button>

        <!-- Progress Bar -->
        <div class="notification-progress"></div>

    </div>


    <style>

        /* =========================================
           NOTIFICATION CONTAINER
        ========================================= */

        .admin-notification {
            position: fixed;

            top: 25px;
            right: 25px;

            z-index: 99999;

            width: auto;
            min-width: 350px;
            max-width: 480px;

            display: flex;
            align-items: center;

            gap: 15px;

            padding: 18px 20px;

            background: rgba(255, 255, 255, 0.98);

            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);

            border: 1px solid rgba(226, 232, 240, 0.9);

            border-radius: 17px;

            box-shadow:
                0 20px 45px rgba(0, 0, 0, 0.14),
                0 5px 15px rgba(0, 0, 0, 0.07);

            overflow: hidden;

            animation:
                notificationIn
                0.55s
                cubic-bezier(.22, 1, .36, 1)
                forwards;
        }


        /* =========================================
           SUCCESS / NOTICE ICON
        ========================================= */

        .notification-icon {

            width: 46px;
            height: 46px;

            min-width: 46px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                linear-gradient(
                    135deg,
                    #10b981,
                    #059669
                );

            color: #ffffff;

            font-size: 23px;
            font-weight: 800;

            box-shadow:
                0 6px 18px
                rgba(16, 185, 129, 0.32);
        }


        /* =========================================
           CONTENT
        ========================================= */

        .notification-content {

            flex: 1;

            min-width: 0;

            padding-right: 3px;
        }


        /* =========================================
           TITLE
        ========================================= */

        .notification-title {

            font-size: 15px;

            font-weight: 800;

            color: #111827;

            margin-bottom: 5px;

            letter-spacing: 0.1px;
        }


        /* =========================================
           MESSAGE
        ========================================= */

        .notification-message {

            font-size: 15px;

            font-weight: 600;

            line-height: 1.55;

            color: #1f2937;

            word-wrap: break-word;

            overflow-wrap: break-word;
        }


        /* =========================================
           CLOSE BUTTON
        ========================================= */

        .notification-close {

            border: none;

            background: #f1f5f9;

            color: #334155;

            font-size: 25px;

            font-weight: 800;

            line-height: 1;

            cursor: pointer;

            width: 36px;
            height: 36px;

            min-width: 36px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            padding: 0;

            transition:
                all 0.2s ease;

            box-shadow:
                0 2px 7px
                rgba(0, 0, 0, 0.10);
        }


        .notification-close:hover {

            background: #fee2e2;

            color: #dc2626;

            transform: scale(1.1);

            box-shadow:
                0 4px 12px
                rgba(220, 38, 38, 0.18);
        }


        .notification-close:active {

            transform: scale(0.94);
        }


        /* =========================================
           PROGRESS BAR
        ========================================= */

        .notification-progress {

            position: absolute;

            bottom: 0;
            left: 0;

            height: 4px;

            width: 100%;

            background:
                linear-gradient(
                    90deg,
                    #10b981,
                    #34d399
                );

            transform-origin: left;

            animation:
                notificationProgress
                6s
                linear
                forwards;
        }


        /* =========================================
           ANIMATION - SLIDE IN
        ========================================= */

        @keyframes notificationIn {

            0% {

                opacity: 0;

                transform:
                    translateX(90px)
                    scale(0.94);
            }

            70% {

                opacity: 1;

                transform:
                    translateX(-5px)
                    scale(1.01);
            }

            100% {

                opacity: 1;

                transform:
                    translateX(0)
                    scale(1);
            }
        }


        /* =========================================
           ANIMATION - SLIDE OUT
        ========================================= */

        @keyframes notificationOut {

            0% {

                opacity: 1;

                transform:
                    translateX(0)
                    scale(1);
            }

            100% {

                opacity: 0;

                transform:
                    translateX(90px)
                    scale(0.94);
            }
        }


        /* =========================================
           PROGRESS ANIMATION
        ========================================= */

        @keyframes notificationProgress {

            from {

                transform:
                    scaleX(1);
            }

            to {

                transform:
                    scaleX(0);
            }
        }


        /* =========================================
           HIDE ANIMATION
        ========================================= */

        .admin-notification.hide {

            animation:
                notificationOut
                0.45s
                ease
                forwards;
        }


        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 480px) {

            .admin-notification {

                top: 15px;

                left: 15px;
                right: 15px;

                width: auto;

                min-width: 0;

                max-width: none;

                padding: 16px;
            }


            .notification-icon {

                width: 42px;
                height: 42px;

                min-width: 42px;

                font-size: 21px;
            }


            .notification-message {

                font-size: 14px;
            }


            .notification-close {

                width: 34px;
                height: 34px;

                min-width: 34px;

                font-size: 23px;
            }
        }

    </style>


    <script>

        /* =========================================
           CLOSE NOTIFICATION
        ========================================= */

        function closeNotification() {

            const notification =
                document.getElementById('adminNotification');

            if (notification) {

                notification.classList.add('hide');

                setTimeout(function() {

                    if (notification) {
                        notification.remove();
                    }

                }, 450);
            }
        }


        /* =========================================
           AUTO CLOSE AFTER 6 SECONDS
        ========================================= */

        setTimeout(function() {

            closeNotification();

        }, 15000);

    </script>


    <?php

        /*
         * Clear the notification after displaying it.
         */

        unset($_SESSION['msg']);
        unset($_SESSION['msg_notification']);

    ?>

<?php endif; ?>