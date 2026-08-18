<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>NNPC IMRA - Tickets</title>

<style>

/* =========================================================
   DESIGN SYSTEM
========================================================= */

:root{
    --sidebar:#172d43;
    --sidebar-2:#1d3b57;
    --sidebar-3:#102438;
    --sidebar-text:#d9e5ef;
    --sidebar-muted:#8fa5b9;

    --primary:#0868bd;
    --primary-dark:#07529a;
    --primary-soft:#eaf4fd;
    --primary-border:#b9d7f1;

    --text:#1c2b39;
    --text-soft:#526170;
    --muted:#7a8793;

    --white:#ffffff;
    --page-bg:#f4f7fa;

    --border:#dce4eb;
    --border-light:#e8edf2;

    --success:#198754;
    --success-bg:#edf9f3;

    --danger:#d83a45;
    --danger-bg:#fff1f2;

    --warning:#ad8200;
    --warning-bg:#fff9e7;

    --shadow-xs:0 1px 3px rgba(25,45,65,.05);
    --shadow-sm:0 3px 10px rgba(25,45,65,.07);
    --shadow-md:0 8px 25px rgba(25,45,65,.09);
    --shadow-lg:0 20px 55px rgba(15,30,45,.20);

    --radius-sm:6px;
    --radius-md:9px;
    --radius-lg:13px;
}


/* =========================================================
   DARK MODE VARIABLES
========================================================= */

body.dark-mode{

    --text:#e5edf4;
    --text-soft:#b8c5d0;
    --muted:#91a1ae;

    --white:#182632;
    --page-bg:#0d1822;

    --border:#2c3d4b;
    --border-light:#263743;

    --primary-soft:#173c5b;
    --primary-border:#315d7e;

    --success-bg:#17372a;
    --danger-bg:#3b1d22;
    --warning-bg:#3c3215;

    --shadow-xs:0 1px 3px rgba(0,0,0,.20);
    --shadow-sm:0 3px 10px rgba(0,0,0,.25);
    --shadow-md:0 8px 25px rgba(0,0,0,.30);
    --shadow-lg:0 20px 55px rgba(0,0,0,.45);

}


/* =========================================================
   RESET
========================================================= */

*{
    box-sizing:border-box;
}

html,
body{
    margin:0;
    padding:0;
    min-height:100%;
}

body{
    font-family:
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        Roboto,
        Arial,
        sans-serif;

    color:var(--text);
    background:var(--page-bg);

    font-size:14px;
    font-weight:500;

    -webkit-font-smoothing:antialiased;

    transition:
        background .25s ease,
        color .25s ease;
}

body.menu-open{
    overflow:hidden;
}

button,
input{
    font-family:inherit;
}

button{
    outline:none;
}

a{
    color:inherit;
}


/* =========================================================
   APP
========================================================= */

.app{
    display:flex;
    min-height:100vh;
}


/* =========================================================
   SIDEBAR OVERLAY
========================================================= */

.sidebar-overlay{
    display:none;

    position:fixed;
    inset:0;

    background:rgba(7,20,33,.58);

    backdrop-filter:blur(3px);

    z-index:999;
}

.sidebar-overlay.show{
    display:block;
}


/* =========================================================
   SIDEBAR
========================================================= */

.sidebar{
    width:218px;
    min-width:218px;

    height:100vh;

    position:fixed;
    left:0;
    top:0;
    bottom:0;

    background:
        linear-gradient(
            180deg,
            var(--sidebar-2) 0%,
            var(--sidebar) 55%,
            var(--sidebar-3) 100%
        );

    color:#fff;

    z-index:1000;

    transform:translateX(0);

    transition:
        transform .28s ease,
        box-shadow .28s ease;

    box-shadow:
        6px 0 28px rgba(8,24,40,.14);

    overflow-y:auto;
    overflow-x:hidden;
}

.sidebar.hidden{
    transform:translateX(-100%);
}


/* =========================================================
   BRAND
========================================================= */

.brand{
    height:74px;

    display:flex;
    align-items:center;

    padding:0 21px;

    position:relative;

    background:
        linear-gradient(
            135deg,
            #244964,
            #17344e
        );

    border-bottom:1px solid rgba(255,255,255,.08);

    color:#fff;

    font-size:18px;
    font-weight:900;

    letter-spacing:1.2px;

    text-shadow:
        0 2px 3px rgba(0,0,0,.20);
}

.brand::before{
    content:"";

    width:4px;
    height:29px;

    border-radius:5px;

    background:#55a7e9;

    margin-right:10px;

    box-shadow:
        0 0 10px rgba(85,167,233,.35);
}

.brand::after{
    content:"";

    position:absolute;

    left:22px;
    right:22px;
    bottom:0;

    height:1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.22),
            transparent
        );
}


/* =========================================================
   SIDEBAR MENU
========================================================= */

.sidebar-menu{
    padding:17px 11px 25px;
}

.menu-section-title{
    padding:8px 12px 7px;

    color:#7891a6;

    font-size:9px;
    font-weight:850;

    letter-spacing:.12em;

    text-transform:uppercase;
}

.menu-item{
    min-height:44px;

    padding:0 13px;

    display:flex;
    align-items:center;

    gap:10px;

    color:var(--sidebar-text);

    text-decoration:none;

    font-size:12px;
    font-weight:750;

    border-radius:7px;

    margin-bottom:4px;

    transition:
        background .18s ease,
        color .18s ease,
        transform .18s ease;
}

.menu-item::before{
    content:"";

    width:5px;
    height:5px;

    flex:0 0 5px;

    border-radius:50%;

    background:#68839a;

    transition:.18s ease;
}

.menu-item:hover{
    color:#fff;

    background:
        rgba(255,255,255,.075);

    transform:translateX(1px);
}

.menu-item:hover::before{
    background:#9dcbf1;
}

.menu-item.active{
    color:#fff;

    background:
        linear-gradient(
            90deg,
            rgba(76,154,216,.22),
            rgba(76,154,216,.06)
        );

    box-shadow:
        inset 3px 0 #65afe9,
        0 3px 10px rgba(0,0,0,.08);
}

.menu-item.active::before{
    background:#77c1f5;

    box-shadow:
        0 0 8px rgba(119,193,245,.75);
}

.dropdown-menu-item{
    cursor:pointer;
}

.dropdown-menu-item .arrow{
    margin-left:auto;

    color:#8ea5b8;

    font-size:10px;

    transition:
        transform .2s ease,
        color .2s ease;
}

.dropdown-menu-item:hover .arrow{
    color:#dcecf8;
}

.menu-dropdown{
    display:none;

    margin:0 5px 7px;

    padding:4px;

    background:
        rgba(5,18,30,.25);

    border:1px solid rgba(255,255,255,.045);

    border-radius:7px;

    overflow:hidden;
}

.menu-dropdown.show{
    display:block;

    animation:
        dropdownIn .18s ease;
}

@keyframes dropdownIn{

    from{
        opacity:0;
        transform:translateY(-4px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

.menu-dropdown .submenu-item{
    min-height:37px;

    padding:0 10px 0 25px;

    display:flex;
    align-items:center;

    color:#b9cbd9;

    text-decoration:none;

    font-size:11px;
    font-weight:650;

    border-radius:5px;

    transition:.15s ease;
}

.menu-dropdown .submenu-item::before{
    content:"›";

    margin-right:7px;

    color:#668aa5;

    font-size:14px;
}

.menu-dropdown .submenu-item:hover{
    background:
        rgba(255,255,255,.07);

    color:#fff;

    padding-left:28px;
}


/* =========================================================
   MAIN
========================================================= */

.main{
    margin-left:218px;

    width:calc(100% - 218px);

    min-width:0;
    min-height:100vh;

    transition:
        margin-left .28s ease,
        width .28s ease;
}

.main.sidebar-hidden{
    margin-left:0;
    width:100%;
}


/* =========================================================
   TOPBAR
========================================================= */

.topbar{
    height:64px;

    background:
        rgba(255,255,255,.98);

    border-bottom:1px solid var(--border);

    display:flex;
    align-items:center;

    padding:0 25px;

    position:sticky;
    top:0;

    z-index:100;

    box-shadow:
        0 2px 12px rgba(25,45,65,.045);

    transition:
        background .25s ease,
        border-color .25s ease;
}

body.dark-mode .topbar{
    background:#14222e;
    box-shadow:0 2px 12px rgba(0,0,0,.25);
}

.topbar-left{
    display:flex;
    align-items:center;

    gap:11px;

    flex:0 0 auto;
}


/* =========================================================
   TOPBAR RIGHT AREA
   FIXED: THEME TOGGLE + PROFILE
========================================================= */

.topbar-right{
    margin-left:auto;

    display:flex;
    align-items:center;

    justify-content:flex-end;

    gap:10px;

    flex:0 0 auto;

    position:relative;

    z-index:110;
}


/* =========================================================
   MENU BUTTON
========================================================= */

.menu-toggle-btn,
.mobile-menu-btn{
    width:38px;
    height:36px;

    border:1px solid #d5dee6;

    background:#fff;

    cursor:pointer;

    display:flex;

    align-items:center;
    justify-content:center;

    flex-direction:column;

    gap:4px;

    border-radius:7px;

    box-shadow:
        0 2px 5px rgba(0,0,0,.035);

    transition:.18s ease;
}

body.dark-mode .menu-toggle-btn,
body.dark-mode .mobile-menu-btn{
    background:#1d2d39;
    border-color:#394c5a;
    box-shadow:0 2px 5px rgba(0,0,0,.20);
}

.menu-toggle-btn:hover,
.mobile-menu-btn:hover{
    background:#f5f9fc;

    border-color:#a9bfce;

    transform:translateY(-1px);

    box-shadow:
        0 4px 10px rgba(25,45,65,.08);
}

body.dark-mode .menu-toggle-btn:hover,
body.dark-mode .mobile-menu-btn:hover{
    background:#263a48;
    border-color:#527086;
}

.menu-toggle-btn span,
.mobile-menu-btn span{
    width:18px;
    height:2px;

    background:#395a73;

    border-radius:3px;

    display:block;
}

body.dark-mode .menu-toggle-btn span,
body.dark-mode .mobile-menu-btn span{
    background:#c9d8e3;
}

.mobile-menu-btn{
    display:none;
}


/* =========================================================
   DARK MODE TOGGLE
========================================================= */

.theme-toggle{
    width:40px;
    height:38px;

    flex:0 0 40px;

    border:1px solid #cbd8e1;

    background:#ffffff;

    color:#31536b;

    border-radius:8px;

    display:flex;
    align-items:center;
    justify-content:center;

    cursor:pointer;

    padding:0;

    position:relative;

    z-index:120;

    font-size:18px;

    line-height:1;

    box-shadow:
        0 2px 6px rgba(0,0,0,.08);

    transition:
        background .18s ease,
        border-color .18s ease,
        color .18s ease,
        transform .18s ease,
        box-shadow .18s ease;
}

.theme-toggle:hover{
    background:#f1f7fb;

    border-color:#9eb8ca;

    color:#075fa8;

    transform:translateY(-1px);

    box-shadow:
        0 5px 12px rgba(25,45,65,.12);
}

.theme-toggle:active{
    transform:translateY(0);
}

body.dark-mode .theme-toggle{
    background:#203440;

    border-color:#506979;

    color:#ffd968;

    box-shadow:
        0 2px 7px rgba(0,0,0,.30);
}

body.dark-mode .theme-toggle:hover{
    background:#294451;

    border-color:#6b8798;

    color:#ffe69a;

    box-shadow:
        0 5px 13px rgba(0,0,0,.35);
}

.theme-icon{
    display:flex;

    align-items:center;
    justify-content:center;

    width:100%;
    height:100%;

    line-height:1;

    user-select:none;

    transition:
        transform .25s ease;
}

.theme-toggle:hover .theme-icon{
    transform:rotate(15deg);
}


/* =========================================================
   DATE TIME
========================================================= */

.page-datetime{
    position:absolute;

    left:50%;
    transform:translateX(-50%);

    display:flex;
    align-items:center;

    gap:22px;

    color:#667987;

    font-size:9px;
    font-weight:900;

    letter-spacing:.08em;

    white-space:nowrap;

    pointer-events:none;
}

body.dark-mode .page-datetime{
    color:#9babb8;
}

.page-datetime span{
    display:inline-flex;
    align-items:center;

    gap:7px;
}

.datetime-value{
    color:#123f60;

    font-size:11px;
    font-weight:950;

    letter-spacing:.025em;

    padding:5px 9px;

    border-radius:6px;

    background:
        linear-gradient(
            135deg,
            #f4f9fd,
            #e9f3fa
        );

    border:1px solid #c9dce9;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.9),
        0 2px 6px rgba(25,65,90,.08);

    text-shadow:
        0 1px 0 rgba(255,255,255,.8);

    transition:
        color .18s ease,
        background .18s ease,
        box-shadow .18s ease;
}

body.dark-mode .datetime-value{
    color:#c9e7fb;

    background:
        linear-gradient(
            135deg,
            #1b3548,
            #193043
        );

    border-color:#31566e;

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.04),
        0 2px 6px rgba(0,0,0,.20);

    text-shadow:none;
}

.datetime-value:hover{
    color:#075b9f;

    background:
        linear-gradient(
            135deg,
            #eef7ff,
            #e3f1fb
        );

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.95),
        0 3px 9px rgba(8,104,189,.12);
}

body.dark-mode .datetime-value:hover{
    color:#e1f3ff;

    background:
        linear-gradient(
            135deg,
            #22445b,
            #1d394d
        );
}


/* =========================================================
   USER AREA
========================================================= */

.topbar-user{
    display:flex;
    align-items:center;

    gap:9px;

    color:#334452;

    font-size:11px;
    font-weight:850;

    cursor:pointer;
    user-select:none;

    position:relative;

    padding:6px 8px;

    border-radius:8px;

    transition:.18s ease;

    white-space:nowrap;
}

body.dark-mode .topbar-user{
    color:#d7e2ea;
}

.topbar-user:hover{
    background:#f3f7fa;
}

body.dark-mode .topbar-user:hover{
    background:#1d2d39;
}

.avatar{
    width:33px;
    height:33px;

    border-radius:50%;

    background:#91a0af;

    color:#fff;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:11px;
    font-weight:900;

    overflow:hidden;

    border:2px solid #fff;

    box-shadow:
        0 2px 7px rgba(0,0,0,.14);

    flex:0 0 33px;
}

body.dark-mode .avatar{
    border-color:#263743;
}

.avatar img{
    width:100%;
    height:100%;

    object-fit:cover;

    display:block;
}

.user-arrow{
    font-size:8px;

    color:#7c8a96;

    transition:.18s ease;
}

body.dark-mode .user-arrow{
    color:#9aabb8;
}

.topbar-user.open .user-arrow{
    transform:rotate(180deg);
}


/* =========================================================
   USER DROPDOWN
========================================================= */

.user-dropdown{
    position:absolute;

    right:0;

    top:calc(100% + 8px);

    width:205px;

    background:#fff;

    border:1px solid var(--border);

    border-radius:9px;

    box-shadow:var(--shadow-md);

    display:none;

    overflow:hidden;

    z-index:2000;
}

body.dark-mode .user-dropdown{
    background:#182832;
    border-color:#30434f;
}

.user-dropdown.show{
    display:block;

    animation:
        dropdownIn .16s ease;
}

.user-dropdown-header{
    padding:14px;

    background:
        linear-gradient(
            135deg,
            #f7fafc,
            #edf3f8
        );

    border-bottom:1px solid var(--border-light);

    color:#304456;

    font-size:11px;
    font-weight:900;
}

.user-last-login{
    padding:11px 14px;

    border-bottom:1px solid #e9eef2;

    color:#7a8792;

    font-size:10px;
    font-weight:600;

    line-height:1.5;
}

body.dark-mode .user-last-login{
    border-bottom-color:#2b3d49;
    color:#9aaab6;
}

.user-last-login strong{
    color:#3d5b72;

    font-weight:850;
}

body.dark-mode .user-last-login strong{
    color:#b8d8ed;
}

.user-dropdown a{
    display:flex;
    align-items:center;

    padding:11px 14px;

    color:#43515d;

    text-decoration:none;

    font-size:11px;
    font-weight:700;

    transition:.15s ease;
}

body.dark-mode .user-dropdown a{
    color:#c2ced7;
}

.user-dropdown a::before{
    content:"";

    width:5px;
    height:5px;

    margin-right:9px;

    border-radius:50%;

    background:#9caab5;
}

.user-dropdown a:hover{
    background:#f4f8fb;

    color:var(--primary);

    padding-left:17px;
}

body.dark-mode .user-dropdown a:hover{
    background:#20343f;
    color:#68b4ed;
}

.user-dropdown a.logout{
    color:#d23d46;

    border-top:1px solid #e8edf1;
}

body.dark-mode .user-dropdown a.logout{
    border-top-color:#30414b;
    color:#f06b73;
}

.user-dropdown a.logout::before{
    background:#dc4c55;
}

.user-dropdown a.logout:hover{
    background:#fff5f5;

    color:#c62f39;
}

body.dark-mode .user-dropdown a.logout:hover{
    background:#392027;
    color:#ff7c83;
}


/* =========================================================
   CONTENT
========================================================= */

.content{
    padding:22px 25px 40px;
}

.content-header{
    display:flex;

    align-items:center;
    justify-content:space-between;

    margin-bottom:16px;
}

.page-heading{
    display:flex;
    flex-direction:column;

    gap:3px;
}

.page-heading h1{
    margin:0;

    color:#203343;

    font-size:19px;
    font-weight:900;

    letter-spacing:-.02em;
}

body.dark-mode .page-heading h1{
    color:#e5edf4;
}

.page-heading p{
    margin:0;

    color:#7a8792;

    font-size:10px;
    font-weight:600;
}

body.dark-mode .page-heading p{
    color:#91a1ae;
}

.btn-create{
    height:38px;

    padding:0 18px;

    border:0;

    border-radius:7px;

    background:
        linear-gradient(
            135deg,
            #1175cf,
            #0758a2
        );

    color:#fff;

    font-size:11px;
    font-weight:850;

    cursor:pointer;

    box-shadow:
        0 6px 15px rgba(8,104,189,.20);

    transition:
        transform .18s ease,
        box-shadow .18s ease,
        filter .18s ease;
}

.btn-create::before{
    content:"+";

    margin-right:7px;

    font-size:15px;
    font-weight:500;

    vertical-align:-1px;
}

.btn-create:hover{
    transform:translateY(-1px);

    box-shadow:
        0 9px 20px rgba(8,104,189,.27);

    filter:brightness(1.04);
}

.btn-create:active{
    transform:translateY(0);
}


/* =========================================================
   SUMMARY CARDS
========================================================= */

.summary-bar{
    display:grid;

    grid-template-columns:
        repeat(6,minmax(120px,1fr));

    gap:10px;

    margin-bottom:17px;
}

.summary{
    min-height:59px;

    position:relative;

    border:1px solid var(--border);

    background:#fff;

    padding:10px 12px;

    display:flex;
    flex-direction:column;
    justify-content:center;

    border-radius:8px;

    color:#71808c;

    font-size:9px;
    font-weight:750;

    box-shadow:var(--shadow-xs);

    transition:.18s ease;

    overflow:hidden;
}

body.dark-mode .summary{
    background:#182832;
    color:#9baab6;
}

.summary::before{
    content:"";

    position:absolute;

    left:0;
    top:0;
    bottom:0;

    width:3px;

    background:#c8d4de;
}

.summary:hover{
    transform:translateY(-2px);

    box-shadow:
        0 6px 16px rgba(25,45,65,.09);
}

body.dark-mode .summary:hover{
    box-shadow:
        0 6px 16px rgba(0,0,0,.30);
}

.summary strong{
    display:block;

    margin-top:4px;

    color:#22394d;

    font-size:17px;
    font-weight:900;
}

body.dark-mode .summary strong{
    color:#e1eaf1;
}

.summary.filtered{
    border-color:#c8dff3;

    background:
        linear-gradient(
            135deg,
            #fff,
            #f5faff
        );

    color:#3f719a;
}

body.dark-mode .summary.filtered{
    border-color:#315d7e;

    background:
        linear-gradient(
            135deg,
            #182f41,
            #172a38
        );

    color:#8bb9d9;
}

.summary.filtered::before{
    background:#1976c8;
}

.summary.filtered strong{
    color:#0868bd;
}

body.dark-mode .summary.filtered strong{
    color:#63b4ed;
}

.summary.due{
    border-color:#ecdfa9;

    background:
        linear-gradient(
            135deg,
            #fff,
            #fffdf5
        );
}

body.dark-mode .summary.due{
    border-color:#675a2b;

    background:
        linear-gradient(
            135deg,
            #302b18,
            #282518
        );
}

.summary.due::before{
    background:#d4aa25;
}

.summary.due strong{
    color:#a27a00;
}

body.dark-mode .summary.due strong{
    color:#e1bd4d;
}

.summary.overdue{
    border-color:darkgreen;

    background:
        linear-gradient(
            135deg,
            #fff,
            #fff7f8
        );
}

body.dark-mode .summary.overdue{
    border-color:#69343a;

    background:
        linear-gradient(
            135deg,
            #321c21,
            #2a1a1e
        );
}

.summary.overdue::before{
    background:#d93c46;
}

.summary.overdue strong{
    color:#ce303a;
}

body.dark-mode .summary.overdue strong{
    color:#f06a73;
}

.reload{
    min-height:59px;

    display:flex;
    align-items:center;
    justify-content:center;

    gap:7px;

    color:#687682;

    font-size:9px;
    font-weight:750;

    white-space:nowrap;
}

body.dark-mode .reload{
    color:#9aaab6;
}

.reload input{
    width:14px;
    height:14px;

    margin:0;

    accent-color:var(--primary);
}


/* =========================================================
   DELETE MULTIPLE
========================================================= */

.delete-multiple-wrapper{
    display:flex;

    justify-content:flex-end;

    margin-top:-7px;

    margin-bottom:17px;
}

.delete-multiple-btn{
    height:31px;

    padding:0 13px;

    border:1px solid #efc4c8;

    border-radius:6px;

    background:#fff5f6;

    color:#c8333d;

    font-size:10px;
    font-weight:850;

    cursor:pointer;

    transition:.16s ease;
}

body.dark-mode .delete-multiple-btn{
    border-color:#67363c;
    background:#321d21;
    color:#f06b73;
}

.delete-multiple-btn:hover{
    background:#ffe9eb;

    border-color:#e6a8ae;

    color:#b92832;
}

body.dark-mode .delete-multiple-btn:hover{
    background:#432328;
    border-color:#804249;
    color:#ff8087;
}

.delete-multiple-btn:active{
    transform:translateY(1px);
}


/* =========================================================
   TABLE CARD
========================================================= */

.table-card{
    background:#fff;

    border:1px solid #dbe3ea;

    border-radius:10px;

    box-shadow:var(--shadow-md);

    overflow:hidden;
}

body.dark-mode .table-card{
    background:#182832;
    border-color:#2c3e4a;
}


/* =========================================================
   TABLE TOOLBAR
========================================================= */

.table-toolbar{
    display:flex;

    align-items:center;
    justify-content:space-between;

    padding:13px 15px;

    border-bottom:1px solid #e4e9ee;

    background:
        linear-gradient(
            180deg,
            #fff,
            #fafcfd
        );

    gap:12px;

    flex-wrap:wrap;
}

body.dark-mode .table-toolbar{
    border-bottom-color:#2c3d48;

    background:
        linear-gradient(
            180deg,
            #1b2c37,
            #182832
        );
}

.filter-buttons{
    display:flex;

    align-items:center;

    gap:5px;

    flex-wrap:wrap;
}


/* =========================================================
   FILTER BUTTONS
========================================================= */

.filter-btn{
    height:31px;

    padding:0 13px;

    background:#fff;

    border:1px solid #d2dce4;

    border-radius:6px;

    color:#5d6b77;

    font-size:10px;
    font-weight:850;

    cursor:pointer;

    transition:.16s ease;
}

body.dark-mode .filter-btn{
    background:#1d2d38;
    border-color:#3a4c58;
    color:#aebcc7;
}

.filter-btn:hover{
    color:#075fae;

    border-color:#a9c9e5;

    background:#f4f9fe;
}

body.dark-mode .filter-btn:hover{
    color:#75bced;
    border-color:#527995;
    background:#203744;
}

.filter-btn.active{
    background:
        linear-gradient(
            135deg,
            #eaf5ff,
            #f4f9ff
        );

    color:#0763b2;

    border-color:#a9cceb;

    box-shadow:
        inset 0 0 0 1px rgba(8,104,189,.03);
}

body.dark-mode .filter-btn.active{
    background:
        linear-gradient(
            135deg,
            #173e5b,
            #1c3547
        );

    color:#6db7ed;

    border-color:#416f91;
}


/* =========================================================
   SEARCH
========================================================= */

.datatable-actions{
    display:flex;

    align-items:center;

    gap:7px;

    margin-left:auto;
}

.table-search{
    width:265px;
    height:32px;

    border:1px solid #cfd9e1;

    border-radius:6px;

    padding:5px 12px;

    background:#fff;

    color:#263641;

    font-size:10.5px;
    font-weight:650;

    outline:none;

    transition:.18s ease;
}

body.dark-mode .table-search{
    background:#14242f;
    border-color:#3a4c58;
    color:#dce6ed;
}

.table-search::placeholder{
    color:#9aa6b0;
}

body.dark-mode .table-search::placeholder{
    color:#718390;
}

.table-search:focus{
    border-color:#7eb3df;

    box-shadow:
        0 0 0 3px rgba(8,104,189,.08);
}


/* =========================================================
   DATE FILTER
========================================================= */

.date-filter-area{
    display:flex;

    align-items:center;

    gap:6px;

    width:100%;

    padding-top:1px;

    border-top:1px solid #edf0f3;

    margin-top:1px;

    padding-top:10px;
}

body.dark-mode .date-filter-area{
    border-top-color:#293b46;
}

.date-label{
    color:#687681;

    font-size:9px;
    font-weight:850;
}

body.dark-mode .date-label{
    color:#9aaab5;
}

.date-input{
    width:145px;
    height:31px;

    border:1px solid #d0dae2;

    border-radius:6px;

    background:#fff;

    color:#364650;

    font-size:10px;
    font-weight:650;

    padding:4px 8px;

    outline:none;

    transition:.18s ease;
}

body.dark-mode .date-input{
    background:#14242f;
    border-color:#3a4c58;
    color:#dce6ed;
    color-scheme:dark;
}

.date-input:focus{
    border-color:#7eb3df;

    box-shadow:
        0 0 0 3px rgba(8,104,189,.08);
}

.clear-date-btn{
    height:31px;

    border:1px solid #d1dae1;

    border-radius:6px;

    background:#f7f9fb;

    color:#5c6975;

    padding:0 12px;

    font-size:9px;
    font-weight:850;

    cursor:pointer;

    transition:.16s ease;
}

body.dark-mode .clear-date-btn{
    background:#202f39;
    border-color:#3a4c58;
    color:#aab8c2;
}

.clear-date-btn:hover{
    background:#edf2f6;

    border-color:#b9c5cf;
}

body.dark-mode .clear-date-btn:hover{
    background:#293d49;
    border-color:#526876;
}


/* =========================================================
   TABLE WRAPPER
========================================================= */

.table-wrapper{
    overflow-x:auto;
    overflow-y:visible;

    scrollbar-width:thin;
}

.table-wrapper::-webkit-scrollbar{
    height:8px;
}

.table-wrapper::-webkit-scrollbar-track{
    background:#f0f4f7;
}

body.dark-mode .table-wrapper::-webkit-scrollbar-track{
    background:#14232d;
}

.table-wrapper::-webkit-scrollbar-thumb{
    background:#c1ccd5;

    border-radius:10px;
}

body.dark-mode .table-wrapper::-webkit-scrollbar-thumb{
    background:#425663;
}


/* =========================================================
   TABLE
========================================================= */

.ticket-table{
    width:100%;

    min-width:1250px;

    border-collapse:separate;

    border-spacing:0;

    table-layout:fixed;
}

.ticket-table th{
    height:46px;

    padding:7px 9px;

    background:
        linear-gradient(
            180deg,
            #f6f9fb,
            #edf2f5
        );

    border-right:1px solid #d9e1e7;
    border-bottom:1px solid #cfd9e1;

    color:#40505e;

    font-size:9px;
    font-weight:900;

    text-transform:uppercase;

    letter-spacing:.045em;

    vertical-align:middle;

    white-space:nowrap;

    position:relative;
}

body.dark-mode .ticket-table th{
    background:
        linear-gradient(
            180deg,
            #243641,
            #1e303b
        );

    border-right-color:#344752;
    border-bottom-color:#40535e;

    color:#c4d1da;
}

.ticket-table th::after{
    content:"";

    position:absolute;

    left:0;
    right:0;
    bottom:0;

    height:1px;

    background:rgba(255,255,255,.8);
}

body.dark-mode .ticket-table th::after{
    background:rgba(255,255,255,.04);
}

.ticket-table th:last-child{
    border-right:0;
}

.ticket-table td{
    padding:12px 9px;

    border-right:1px solid #e1e7ec;
    border-bottom:1px solid #e4e9ed;

    vertical-align:top;

    font-size:10.5px;

    line-height:1.5;

    color:#2b3741;

    font-weight:600;

    word-break:break-word;
}

body.dark-mode .ticket-table td{
    border-right-color:#2d3e49;
    border-bottom-color:#2d3e49;
    color:#c8d3db;
}

.ticket-table td:last-child{
    border-right:0;
}

.ticket-table tbody tr{
    background:#fff;

    transition:
        background .14s ease,
        box-shadow .14s ease;
}

body.dark-mode .ticket-table tbody tr{
    background:#182832;
}

.ticket-table tbody tr:hover{
    background:#f5faff;

    box-shadow:
        inset 3px 0 #66a9df;
}

body.dark-mode .ticket-table tbody tr:hover{
    background:#1e3441;
}

.ticket-table tbody tr.critical-row{
    background:#fffafb;
}

body.dark-mode .ticket-table tbody tr.critical-row{
    background:#211c21;
}

.ticket-table tbody tr.critical-row:hover{
    background:#fff5f6;

    box-shadow:
        inset 3px 0 #dc5a62;
}

body.dark-mode .ticket-table tbody tr.critical-row:hover{
    background:#322126;

    box-shadow:
        inset 3px 0 #dc5a62;
}


/* =========================================================
   COLUMN WIDTHS
========================================================= */

.col-check{width:40px;}
.col-id{width:72px;}
.col-tracking{width:78px;}
.col-submitted{width:84px;}
.col-updated{width:84px;}
.col-category{width:108px;}
.col-name{width:100px;}
.col-subject{width:135px;}
.col-status{width:68px;}
.col-owner{width:112px;}
.col-date{width:98px;}
.col-source{width:122px;}
.col-state{width:70px;}
.col-zone{width:90px;}
.col-corridor{width:88px;}
.col-priority{width:78px;}
.col-action{width:105px;}


/* =========================================================
   ACTION LINKS
========================================================= */

.action-links{
    display:flex;

    align-items:center;

    gap:8px;

    white-space:nowrap;
}

.action-link{
    text-decoration:none;

    font-size:10px;
    font-weight:850;

    transition:.15s ease;
}

.action-edit{
    color:#0968aa;
}

body.dark-mode .action-edit{
    color:#67b5ed;
}

.action-edit:hover{
    color:#064c7e;

    text-decoration:underline;
}

body.dark-mode .action-edit:hover{
    color:#91d0fa;
}

.action-delete{
    color:#d33b45;
}

body.dark-mode .action-delete{
    color:#f06b73;
}

.action-delete:hover{
    color:#b72530;

    text-decoration:underline;
}

body.dark-mode .action-delete:hover{
    color:#ff858c;
}


/* =========================================================
   CHECKBOX
========================================================= */

.checkbox-cell{
    text-align:center;
}

.checkbox-cell input,
.ticket-table th input{
    width:13px;
    height:13px;

    cursor:pointer;

    accent-color:var(--primary);
}


/* =========================================================
   LINKS
========================================================= */

.ticket-link,
.tracking{
    color:#0968aa;

    text-decoration:none;

    font-weight:850;

    transition:.15s ease;
}

body.dark-mode .ticket-link,
body.dark-mode .tracking{
    color:#67b5ed;
}

.ticket-link:hover,
.tracking:hover{
    color:#064c7e;

    text-decoration:underline;
}

body.dark-mode .ticket-link:hover,
body.dark-mode .tracking:hover{
    color:#9bd5fb;
}


/* =========================================================
   STATUS
========================================================= */

.status-new,
.status-open,
.status-closed{
    display:inline-flex;

    align-items:center;

    min-height:21px;

    padding:2px 8px;

    border-radius:20px;

    font-size:9px;
    font-weight:900;
}

.status-new{
    color:#c62f39;

    background:
        var(--danger-bg);

    border:1px solid #f1c7cb;
}

body.dark-mode .status-new{
    color:#ff7b84;
    border-color:#69363d;
}

.status-open{
    color:#0962ad;

    background:
        var(--primary-soft);

    border:1px solid #c4dff4;
}

body.dark-mode .status-open{
    color:#70baf0;
    border-color:#315e7e;
}

.status-closed{
    color:#147847;

    background:
        var(--success-bg);

    border:1px solid #c7e8d7;
}

body.dark-mode .status-closed{
    color:#68d19b;
    border-color:#31654a;
}


/* =========================================================
   PRIORITY
========================================================= */

.priority{
    display:inline-flex;

    align-items:center;

    gap:5px;

    color:#c82e38;

    font-weight:850;
}

body.dark-mode .priority{
    color:#f16a73;
}

.priority-flag{
    width:12px;
    height:9px;

    background:#df3944;

    display:inline-block;

    position:relative;

    border-radius:1px;

    box-shadow:
        0 1px 2px rgba(220,53,69,.2);
}

.priority-flag::after{
    content:"";

    position:absolute;

    right:-3px;
    top:0;

    width:0;
    height:0;

    border-top:4.5px solid transparent;
    border-bottom:4.5px solid transparent;
    border-right:3px solid white;
}


/* =========================================================
   DATE / TIME
========================================================= */

.date-time{
    white-space:nowrap;

    line-height:1.35;

    font-weight:650;
}

.date{
    display:block;
}

.time{
    display:block;

    margin-top:2px;

    color:#78858f;

    font-size:9.5px;
}

body.dark-mode .time{
    color:#8999a5;
}


/* =========================================================
   FOOTER
========================================================= */

.datatable-footer{
    min-height:57px;

    border-top:1px solid #dde5eb;

    display:flex;

    align-items:center;
    justify-content:space-between;

    padding:9px 15px;

    background:
        linear-gradient(
            180deg,
            #fcfdfe,
            #f7f9fb
        );
}

body.dark-mode .datatable-footer{
    border-top-color:#2d3f4a;

    background:
        linear-gradient(
            180deg,
            #1a2b36,
            #172832
        );
}

.table-info{
    color:#687680;

    font-size:10px;
    font-weight:750;
}

body.dark-mode .table-info{
    color:#9cabb6;
}

.pagination{
    display:flex;

    align-items:center;

    gap:4px;
}

.page-btn{
    height:29px;
    min-width:30px;

    border:1px solid #d1dae2;

    border-radius:5px;

    background:#fff;

    color:#596672;

    font-size:10px;
    font-weight:800;

    cursor:pointer;

    transition:.15s ease;
}

body.dark-mode .page-btn{
    background:#1d2e39;
    border-color:#3a4c58;
    color:#aebbc5;
}

.page-btn:hover{
    background:#f1f5f8;

    border-color:#b8c6d1;
}

body.dark-mode .page-btn:hover{
    background:#293d49;
    border-color:#526876;
}

.page-btn.active{
    background:
        linear-gradient(
            135deg,
            #1478d0,
            #075ba6
        );

    color:#fff;

    border-color:#0b62ad;

    box-shadow:
        0 3px 7px rgba(8,104,189,.17);
}


/* =========================================================
   TICKET CATEGORY MODAL
========================================================= */

.ticket-category-modal{
    position:fixed;

    inset:0;

    display:none;

    align-items:center;
    justify-content:center;

    padding:20px;

    background:
        rgba(8,23,38,.63);

    backdrop-filter:blur(5px);

    z-index:3000;
}

.ticket-category-modal.show{
    display:flex;
}

.ticket-category-dialog{
    width:min(820px,96vw);

    max-height:90vh;

    overflow-y:auto;

    position:relative;

    background:#fff;

    border:1px solid rgba(255,255,255,.85);

    border-radius:14px;

    box-shadow:var(--shadow-lg);

    padding:28px 28px 29px;

    animation:
        modalIn .2s ease;
}

body.dark-mode .ticket-category-dialog{
    background:#182832;
    border-color:#344752;
}

@keyframes modalIn{

    from{
        opacity:0;
        transform:translateY(13px) scale(.975);
    }

    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }

}

.ticket-category-dialog::before{
    content:"";

    position:absolute;

    left:0;
    top:0;
    right:0;

    height:4px;

    border-radius:14px 14px 0 0;

    background:
        linear-gradient(
            90deg,
            #0759a2,
            #1381d5,
            #0759a2
        );
}

.ticket-category-title{
    margin:0;

    padding-right:40px;

    color:#203545;

    font-size:17px;

    font-weight:900;

    letter-spacing:-.015em;
}

body.dark-mode .ticket-category-title{
    color:#e4edf3;
}

.ticket-category-title::after{
    content:"Choose the type of ticket you want to create";

    display:block;

    margin-top:6px;

    color:#7c8994;

    font-size:10px;

    font-weight:600;
}

body.dark-mode .ticket-category-title::after{
    color:#94a4af;
}

.ticket-category-grid{
    display:grid;

    grid-template-columns:
        1fr 1fr;

    gap:9px;

    margin-top:21px;
}

.ticket-category-option{
    min-height:50px;

    border:1px solid #e0e7ed;

    background:
        linear-gradient(
            180deg,
            #fff,
            #fafcfd
        );

    display:flex;

    align-items:center;

    gap:11px;

    padding:8px 12px;

    border-radius:8px;

    color:#2d3b47;

    font-size:10px;

    font-weight:750;

    line-height:1.35;

    text-align:left;

    cursor:pointer;

    transition:
        background .15s ease,
        border-color .15s ease,
        box-shadow .15s ease,
        transform .15s ease;
}

body.dark-mode .ticket-category-option{
    border-color:#344752;

    background:
        linear-gradient(
            180deg,
            #1c2e39,
            #192a34
        );

    color:#cdd8df;
}

.ticket-category-option:hover,
.ticket-category-option:focus-visible{
    background:#f3f9ff;

    border-color:#a5c9e9;

    box-shadow:
        0 4px 12px rgba(22,102,171,.09);

    transform:translateY(-1px);

    outline:none;
}

body.dark-mode .ticket-category-option:hover,
body.dark-mode .ticket-category-option:focus-visible{
    background:#213b4a;

    border-color:#4c7793;
}

.ticket-category-option.selected{
    background:#edf7ff;

    border-color:#75afe0;

    box-shadow:
        0 0 0 2px rgba(8,104,189,.07);
}

body.dark-mode .ticket-category-option.selected{
    background:#173d56;

    border-color:#4f91c3;
}

.ticket-category-radio{
    width:23px;
    height:23px;

    min-width:23px;

    border-radius:50%;

    background:#f1f5f8;

    border:1px solid #d9e1e7;

    display:inline-flex;

    align-items:center;
    justify-content:center;

    transition:.15s ease;
}

body.dark-mode .ticket-category-radio{
    background:#263943;
    border-color:#425764;
}

.ticket-category-option.selected
.ticket-category-radio{
    background:#126fbe;

    border-color:#126fbe;

    box-shadow:
        0 2px 6px rgba(8,104,189,.20);
}

.ticket-category-option.selected
.ticket-category-radio::after{
    content:"";

    width:7px;
    height:7px;

    border-radius:50%;

    background:#fff;
}

.ticket-category-name{
    flex:1;
}

.ticket-category-close{
    position:absolute;

    top:14px;
    right:15px;

    width:32px;
    height:32px;

    border:1px solid #dde4e9;

    border-radius:7px;

    background:#f8fafb;

    color:#687681;

    font-size:21px;

    line-height:1;

    cursor:pointer;

    transition:.15s ease;
}

body.dark-mode .ticket-category-close{
    background:#21323d;
    border-color:#3a4c57;
    color:#a9b7c1;
}

.ticket-category-close:hover{
    background:#fff1f2;

    border-color:#efc4c8;

    color:#c62f38;
}

body.dark-mode .ticket-category-close:hover{
    background:#3a2025;

    border-color:#704047;

    color:#ff7a82;
}


/* =========================================================
   SCROLLBAR
========================================================= */

::-webkit-scrollbar{
    width:8px;
    height:8px;
}

::-webkit-scrollbar-track{
    background:#eef2f5;
}

body.dark-mode ::-webkit-scrollbar-track{
    background:#13212a;
}

::-webkit-scrollbar-thumb{
    background:#c2ccd5;

    border-radius:10px;
}

body.dark-mode ::-webkit-scrollbar-thumb{
    background:#40535f;
}

::-webkit-scrollbar-thumb:hover{
    background:#aebac5;
}

body.dark-mode ::-webkit-scrollbar-thumb:hover{
    background:#526874;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1180px){

    .summary-bar{
        grid-template-columns:
            repeat(3,minmax(150px,1fr));
    }

}


@media(max-width:1000px){

    .sidebar{
        width:245px;
        min-width:245px;

        transform:translateX(-100%);

        box-shadow:
            9px 0 32px rgba(0,0,0,.20);
    }

    .sidebar.open{
        transform:translateX(0);
    }

    .sidebar.hidden{
        transform:translateX(-100%);
    }

    .main{
        margin-left:0;
        width:100%;
    }

    .main.sidebar-hidden{
        margin-left:0;
        width:100%;
    }

    .menu-toggle-btn{
        display:none;
    }

    .mobile-menu-btn{
        display:flex;
    }

    .brand{
        height:67px;
    }

    .menu-item{
        min-height:46px;

        padding:0 18px;

        font-size:13px;
    }

    .content{
        padding:18px 16px 32px;
    }

    .content-header{
        align-items:flex-end;
    }

    .summary-bar{
        grid-template-columns:
            repeat(2,minmax(150px,1fr));
    }

    .table-toolbar{
        flex-direction:column;
        align-items:stretch;
    }

    .filter-buttons{
        overflow-x:auto;

        flex-wrap:nowrap;

        padding-bottom:3px;
    }

    .filter-btn{
        flex-shrink:0;
    }

    .datatable-actions{
        width:100%;

        margin-left:0;
    }

    .table-search{
        width:100%;
    }

    .date-filter-area{
        flex-wrap:wrap;
    }

    .delete-multiple-wrapper{
        margin-top:-5px;
    }

}


@media(max-width:700px){

    .topbar{
        height:57px;

        padding:0 10px;
    }

    .topbar-right{
        gap:5px;
    }

    .page-datetime{
        position:static;

        transform:none;

        margin-left:auto;
        margin-right:auto;

        gap:9px;

        font-size:8px;
    }

    .datetime-value{
        font-size:9px;

        padding:4px 6px;
    }

    .theme-toggle{
        width:34px;
        height:32px;

        flex-basis:34px;

        font-size:15px;
    }

    .topbar-user{
        font-size:9px;

        padding:4px;
    }

    .avatar{
        width:29px;
        height:29px;

        flex-basis:29px;
    }

    .content{
        padding:12px 9px 26px;
    }

    .content-header{
        display:block;

        margin-bottom:12px;
    }

    .page-heading{
        margin-bottom:10px;
    }

    .page-heading h1{
        font-size:17px;
    }

    .btn-create{
        width:100%;
    }

    .summary-bar{
        grid-template-columns:
            1fr 1fr;

        gap:7px;
    }

    .summary{
        min-height:56px;

        padding:9px 10px;
    }

    .summary strong{
        font-size:15px;
    }

    .reload{
        grid-column:1 / -1;

        min-height:40px;

        justify-content:flex-start;

        padding-left:3px;
    }

    .delete-multiple-wrapper{
        margin-top:-3px;
        margin-bottom:12px;
    }

    .table-card{
        border-radius:7px;
    }

    .table-toolbar{
        padding:10px;
    }

    .date-filter-area{
        display:grid;

        grid-template-columns:
            1fr 1fr;

        gap:6px;
    }

    .date-label:first-child{
        grid-column:1 / -1;
    }

    .date-input{
        width:100%;
    }

    .clear-date-btn{
        width:100%;

        grid-column:1 / -1;
    }

    .datatable-footer{
        flex-direction:column;

        align-items:flex-start;

        gap:10px;

        padding:10px;
    }

    .pagination{
        width:100%;

        overflow-x:auto;

        padding-bottom:3px;
    }

    .ticket-category-modal{
        padding:9px;
    }

    .ticket-category-dialog{
        width:100%;

        max-height:93vh;

        padding:23px 13px 16px;

        border-radius:11px;
    }

    .ticket-category-grid{
        grid-template-columns:1fr;

        gap:7px;
    }

    .ticket-category-title{
        font-size:15px;
    }

}


@media(max-width:500px){

    .topbar{
        padding:0 8px;
    }

    .page-datetime{
        gap:5px;

        font-size:7px;
    }

    .datetime-value{
        font-size:8px;

        padding:3px 5px;
    }

    .topbar-right{
        gap:4px;
    }

    .topbar-user > span:not(.user-arrow){
        display:none;
    }

    .user-dropdown{
        right:-3px;
    }

}


@media(max-width:450px){

    .page-datetime{
        display:none;
    }

    .topbar{
        justify-content:space-between;
    }

    .topbar-left{
        margin-right:auto;
    }

    .topbar-right{
        margin-left:auto;
    }

    .summary-bar{
        grid-template-columns:1fr;
    }

    .reload{
        grid-column:auto;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media(prefers-reduced-motion:reduce){

    *,
    *::before,
    *::after{
        animation-duration:.01ms !important;
        animation-iteration-count:1 !important;
        transition-duration:.01ms !important;
    }

}

</style>

</head>


<body>

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>


<!-- =========================================================
     CREATE NEW TICKET CATEGORY POPUP
========================================================= -->

<div
    class="ticket-category-modal"
    id="ticketCategoryModal"
    aria-hidden="true"
>

    <div
        class="ticket-category-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="ticketCategoryTitle"
    >

        <button
            type="button"
            class="ticket-category-close"
            id="ticketCategoryClose"
            aria-label="Close ticket category popup"
        >
            &times;
        </button>


        <h2
            class="ticket-category-title"
            id="ticketCategoryTitle"
        >
            Select ticket category
        </h2>


        <div
            class="ticket-category-grid"
            id="ticketCategoryGrid"
        >

            <button type="button" class="ticket-category-option" data-category="General">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">General</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="PIPELINE VANDALISM">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">PIPELINE VANDALISM</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="ILLEGAL REFINERIES">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">ILLEGAL REFINERIES</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="ILLEGAL VESSELS">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">ILLEGAL VESSELS</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="EQUIPMENT VANDALISM">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">EQUIPMENT VANDALISM</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="ILLEGAL CONNECTION">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">ILLEGAL CONNECTION</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="OIL SPILL">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">OIL SPILL</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="COMMUNITY ISSUES">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">COMMUNITY ISSUES</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="WHISTLE BLOWING">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">WHISTLE BLOWING</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="INCIDENCE_FIN">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">INCIDENCE_FIN</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="ILLEGAL TRUCKING">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">ILLEGAL TRUCKING</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="ARREST/DESTRUCTION OF WOODEN BOAT, SPEED BOAT, TRUCK &amp; CARS">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">
                    ARREST/DESTRUCTION OF WOODEN BOAT, SPEED BOAT, TRUCK &amp; CARS
                </span>
            </button>

            <button type="button" class="ticket-category-option" data-category="STATE_HOUSE_ANNEX">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">STATE_HOUSE_ANNEX</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="INCIDENCE_DSS">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">INCIDENCE_DSS</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="DOCUMENT VALIDATION">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">DOCUMENT VALIDATION</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="VESSELS TRACKING">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">VESSELS TRACKING</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="VESSELS ARREST">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">VESSELS ARREST</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="COMMUNITY ENGAGEMENT">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">COMMUNITY ENGAGEMENT</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="GSIA OPERATIONS">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">GSIA OPERATIONS</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="OPERATORS REPORT">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">OPERATORS REPORT</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="SECURITY REPORT">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">SECURITY REPORT</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="TERMINAL RECEIPT">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">TERMINAL RECEIPT</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="THEFT">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">THEFT</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="PRODUCT IMPORT VESSELS REPORT">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">PRODUCT IMPORT VESSELS REPORT</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="OPERATION WHIRLWIND">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">OPERATION WHIRLWIND</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="AVERSION">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">AVERSION</span>
            </button>

            <button type="button" class="ticket-category-option" data-category="STRATEGIC REPORTING FOR OTHER SECURITY AND MAINTENANCE ACTIVITIES">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">
                    STRATEGIC REPORTING FOR OTHER SECURITY AND MAINTENANCE ACTIVITIES
                </span>
            </button>

            <button type="button" class="ticket-category-option" data-category="JIV Reports">
                <span class="ticket-category-radio"></span>
                <span class="ticket-category-name">JIV Reports</span>
            </button>

        </div>

    </div>

</div>


<div class="app">


<!-- =========================================================
     SIDEBAR
========================================================= -->

<aside
    class="sidebar"
    id="sidebar"
>

    <div class="brand">
        NNPC IMRA
    </div>


    <nav class="sidebar-menu">

        <div class="menu-section-title">
            Workspace
        </div>


        <a href="#" class="menu-item active">
            Tickets
        </a>


        <a href="#" class="menu-item">
            Reporters
        </a>


        <div
            class="menu-item dropdown-menu-item"
            data-dropdown="reportsDropdown"
        >

            <span>
                Reports
            </span>

            <span class="arrow">
                ▾
            </span>

        </div>


        <div class="menu-dropdown" id="reportsDropdown" >

            <a href="#" class="submenu-item">
                Run Reports
            </a>

            <a href="#" class="submenu-item">
                Export Report
            </a>

        </div>


        <div class="menu-item dropdown-menu-item" data-dropdown="modulesDropdown">

            <span>
                Modules
            </span>

            <span class="arrow">
                ▾
            </span>

        </div>
      


        <div class="menu-dropdown" id="modulesDropdown">

            <a href="#" class="submenu-item">
                Uploads
            </a>

        </div> 
          <div class="menu-item dropdown-menu-item" data-dropdown="developerDropdown">

            <span>
                Developer
            </span>

            <span class="arrow">
                ▾
            </span>

        </div>
        <div class="menu-dropdown" id="developerDropdown">

            <a href="#" class="submenu-item">
                Ticket Category
            </a>
            <a href="#" class="submenu-item">
                Incidence Source
            </a>  
            <a href="#" class="submenu-item">
                Priority 
            </a> 
            <a href="#" class="submenu-item">
                Pipeline 
            </a>
        <a href="#" class="submenu-item">
                Corridor 
            </a>
            <a href="#" class="submenu-item">
                Zone 
            </a> 
            <a href="#" class="submenu-item">
                Operator 
            </a>


        </div>

    </nav>

</aside>


<!-- =========================================================
     MAIN
========================================================= -->

<main class="main">


<!-- =========================================================
     TOPBAR
========================================================= -->

<header class="topbar">

    <div class="topbar-left">

        <button
            type="button"
            class="menu-toggle-btn"
            id="menuToggleBtn"
            aria-label="Show or hide menu"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>


        <button
            type="button"
            class="mobile-menu-btn"
            id="mobileMenuBtn"
            aria-label="Open menu"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>


    <div
        class="page-datetime"
        aria-label="Current date and time"
    >

        <span>

            DATE:

            <span
                class="datetime-value"
                id="currentDate"
            >
                --
            </span>

        </span>


        <span>

            TIME:

            <span
                class="datetime-value"
                id="currentTime"
            >
                --
            </span>

        </span>

    </div>


    <!-- =====================================================
         TOPBAR RIGHT
    ====================================================== -->

    <div class="topbar-right">


        <!-- =================================================
             LIGHT / DARK MODE TOGGLE
        ================================================== -->

        <button
            type="button"
            class="theme-toggle"
            id="themeToggle"
            aria-label="Switch to dark mode"
            title="Switch to dark mode"
        >

            <span
                class="theme-icon"
                id="themeIcon"
            >
                ☾
            </span>

        </button>


        <!-- =================================================
             USER
        ================================================== -->

        <div
            class="topbar-user"
            id="userMenuButton"
        >

            <div class="avatar">

                <img
                    src="https://ui-avatars.com/api/?name=New+Guard+Security&background=9ba7b8&color=ffffff&size=64"
                    alt="New Guard Security profile"
                >

            </div>


            <span>
                NEW GUARD SECU...
            </span>


            <span class="user-arrow">
                ▼
            </span>


            <div
                class="user-dropdown"
                id="userDropdown"
            >

                <div class="user-last-login">

                    Last Login:

                    <strong id="lastLoginTime">
                        --
                    </strong>

                </div>


                <a href="#">
                    Profile
                </a>


                <a href="#">
                    Settings
                </a>


                <a
                    href="#"
                    class="logout"
                >
                    Logout
                </a>

            </div>

        </div>

    </div>

</header>


<!-- =========================================================
     CONTENT
========================================================= -->

<section class="content">


<div class="content-header">

    <div class="page-heading">

        <h1>
            Tickets
        </h1>

        <p>
            Monitor, manage and track reported incidents
        </p>

    </div>


    <button
        class="btn-create"
        type="button"
    >
        Create New Ticket
    </button>

</div>


<!-- =========================================================
     SUMMARY
========================================================= -->

<div class="summary-bar">

    <div class="summary filtered">

        All tickets

        <strong id="filteredCount">
            20980
        </strong>

    </div>


    <div class="summary">

        New tickets

        <strong>
            157
        </strong>

    </div>


    <div class="summary">

        Opened tickets

        <strong>
            19842
        </strong>

    </div>


    <div class="summary">

        In progress

        <strong>
            981
        </strong>

    </div>


    <div class="summary due">

        Replied

        <strong>
            0
        </strong>

    </div>


    <div class="summary overdue">

        Resolved

        <strong>
            27
        </strong>

    </div>


    <label class="reload">

        <input
            type="checkbox"
            checked
        >

        <span id="reloadText">
            Auto reload page (49)
        </span>

    </label>

</div>


<!-- =========================================================
     DELETE MULTIPLE
========================================================= -->

<div class="delete-multiple-wrapper">

    <button
        class="delete-multiple-btn"
        type="button"
        id="deleteMultipleBtn"
    >
        Delete Selected
    </button>

</div>


<!-- =========================================================
     TABLE CARD
========================================================= -->

<div class="table-card">


<div class="table-toolbar">


<div class="filter-buttons">

    <button
        class="filter-btn active"
        type="button"
        data-filter="all"
    >
        All
    </button>


    <button
        class="filter-btn"
        type="button"
        data-filter="new"
    >
        New
    </button>


    <button
        class="filter-btn"
        type="button"
        data-filter="opened"
    >
        Opened
    </button>


    <button
        class="filter-btn"
        type="button"
        data-filter="in-progress"
    >
        In progress
    </button>


    <button
        class="filter-btn"
        type="button"
        data-filter="replied"
    >
        Replied
    </button>


    <button
        class="filter-btn"
        type="button"
        data-filter="resolved"
    >
        Resolved
    </button>

</div>


<div class="datatable-actions">

    <input
        type="search"
        id="tableSearch"
        class="table-search"
        placeholder="Search tickets..."
        autocomplete="off"
    >

</div>


<div class="date-filter-area">

    <span class="date-label">
        Date Filter:
    </span>


    <span class="date-label">
        From
    </span>


    <input
        type="date"
        id="dateFrom"
        class="date-input"
    >


    <span class="date-label">
        To
    </span>


    <input
        type="date"
        id="dateTo"
        class="date-input"
    >


    <button
        type="button"
        id="clearDate"
        class="clear-date-btn"
    >
        Clear Date
    </button>

</div>

</div>


<!-- =========================================================
     TABLE
========================================================= -->

<div class="table-wrapper">

<table
    class="ticket-table"
    id="ticketTable"
>

<thead>

<tr>

<th class="col-check">
    <input
        type="checkbox"
        id="selectAll"
    >
</th>

<th class="col-id">
    ID ↕
</th>

<th class="col-tracking">
    TRACKING ID ↕
</th>

<th class="col-submitted">
    SUBMITTED ↕
</th>

<th class="col-updated">
    UPDATED ↕
</th>

<th class="col-category">
    CATEGORY ↕
</th>

<th class="col-name">
    NAME ↕
</th>

<th class="col-subject">
    SUBJECT ↕
</th>

<th class="col-status">
    STATUS ↕
</th>

<th class="col-owner">
    OWNER ↕
</th>

<th class="col-date">
    INCIDENCE DATE ↕
</th>

<th class="col-source">
    INCIDENCE SOURCE ↕
</th>

<th class="col-state">
    STATE ↕
</th>

<th class="col-zone">
    ZONE ↕
</th>

<th class="col-corridor">
    CORRIDOR ↕
</th>

<th class="col-priority">
    PRIORITY ↕
</th>

<th class="col-action">
    ACTION
</th>

</tr>

</thead>


<tbody>


<!-- ROW 1 -->

<tr
    class="critical-row"
    data-status="new"
    data-priority="critical"
    data-owner="unassigned"
>

<td class="checkbox-cell">
    <input type="checkbox">
</td>

<td>
    <a href="#" class="ticket-link">
        22783
    </a>
</td>

<td>
    <a href="#" class="tracking">
        7P5-R7H-<br>D92U
    </a>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-13</span>
        <span class="time">12:48:53</span>
    </div>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-13</span>
        <span class="time">12:48:53</span>
    </div>
</td>

<td>
    ILLEGAL<br>
    CONNECTION
</td>

<td>
    Oando
</td>

<td>
    <a href="#" class="ticket-link">
        Illegal<br>
        Connection
    </a>
</td>

<td>
    <span class="status-new">
        New
    </span>
</td>

<td>
    Unassigned
</td>

<td>
    August 9, 2026
</td>

<td>
    OANDO
</td>

<td>
    Rivers
</td>

<td>
    OANDO<br>
    Zone B -<br>
    Area 8
</td>

<td>
    Central
</td>

<td>
    <span class="priority">
        <span class="priority-flag"></span>
        Critical
    </span>
</td>

<td>
    <div class="action-links">
        <a href="#" class="action-link action-edit">Reply</a>
        <a href="#" class="action-link action-delete">Delete</a>
    </div>
</td>

</tr>


<!-- ROW 2 -->

<tr
    class="critical-row"
    data-status="new"
    data-priority="critical"
    data-owner="unassigned"
>

<td class="checkbox-cell">
    <input type="checkbox">
</td>

<td>
    <a href="#" class="ticket-link">
        22782
    </a>
</td>

<td>
    <a href="#" class="tracking">
        PD5-ALJ-<br>
        8489
    </a>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-13</span>
        <span class="time">12:41:01</span>
    </div>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-13</span>
        <span class="time">12:41:01</span>
    </div>
</td>

<td>
    PIPELINE<br>
    VANDALISM
</td>

<td>
    Oando
</td>

<td>
    <a href="#" class="ticket-link">
        Pipeline<br>
        Vandalism
    </a>
</td>

<td>
    <span class="status-new">
        New
    </span>
</td>

<td>
    Unassigned
</td>

<td>
    August 6, 2026
</td>

<td>
    OANDO
</td>

<td>
    Rivers
</td>

<td>
    OANDO<br>
    Zone C -<br>
    Area 13
</td>

<td>
    Central
</td>

<td>
    <span class="priority">
        <span class="priority-flag"></span>
        Critical
    </span>
</td>

<td>
    <div class="action-links">
        <a href="#" class="action-link action-edit">Reply</a>
        <a href="#" class="action-link action-delete">Delete</a>
    </div>
</td>

</tr>


<!-- ROW 3 -->

<tr
    class="critical-row"
    data-status="new"
    data-priority="critical"
    data-owner="unassigned"
>

<td class="checkbox-cell">
    <input type="checkbox">
</td>

<td>
    <a href="#" class="ticket-link">
        22781
    </a>
</td>

<td>
    <a href="#" class="tracking">
        NZD-AXX-<br>
        T5TE
    </a>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-13</span>
        <span class="time">12:17:59</span>
    </div>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-13</span>
        <span class="time">12:17:59</span>
    </div>
</td>

<td>
    VESSELS<br>
    TRACKING
</td>

<td>
    NNPCL<br>
    COMMAND AND<br>
    CONTROL<br>
    CENTER
</td>

<td>
    <a href="#" class="ticket-link">
        VESSELS WITH AIS<br>
        INFRACTIONS<br>
        AS OF 13<br>
        AUGUST 2026
    </a>
</td>

<td>
    <span class="status-new">
        New
    </span>
</td>

<td>
    Unassigned
</td>

<td>
    August 13, 2026
</td>

<td>
    NNPCL<br>
    COMMAND<br>
    AND CONTROL<br>
    CENTER
</td>

<td></td>

<td></td>

<td>
    Deep Blue<br>
    Water
</td>

<td>
    <span class="priority">
        <span class="priority-flag"></span>
        Critical
    </span>
</td>

<td>
    <div class="action-links">
        <a href="#" class="action-link action-edit">Reply</a>
        <a href="#" class="action-link action-delete">Delete</a>
    </div>
</td>

</tr>


<!-- ROW 4 -->

<tr
    class="critical-row"
    data-status="new"
    data-priority="critical"
    data-owner="assigned"
>

<td class="checkbox-cell">
    <input type="checkbox">
</td>

<td>
    <a href="#" class="ticket-link">
        22780
    </a>
</td>

<td>
    <a href="#" class="tracking">
        T8V-9WJ-<br>
        X3PR
    </a>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-13</span>
        <span class="time">05:56:00</span>
    </div>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-13</span>
        <span class="time">11:39:56</span>
    </div>
</td>

<td>
    VESSELS<br>
    TRACKING
</td>

<td>
    NNPCL<br>
    COMMAND AND<br>
    CONTROL<br>
    CENTER
</td>

<td>
    <a href="#" class="ticket-link">
        VESSELS WITH AIS<br>
        INFRACTIONS<br>
        AS AT 13-AUG-<br>
        25 0600HRS
    </a>
</td>

<td>
    <span class="status-new">
        New
    </span>
</td>

<td>
    NIGERIAN<br>
    NAVY (VESSEL<br>
    TRACKING)
</td>

<td>
    August 13, 2026
</td>

<td>
    NNPCL<br>
    COMMAND<br>
    AND CONTROL<br>
    CENTER
</td>

<td></td>

<td></td>

<td>
    Deep Blue<br>
    Water
</td>

<td>
    <span class="priority">
        <span class="priority-flag"></span>
        Critical
    </span>
</td>

<td>
    <div class="action-links">
        <a href="#" class="action-link action-edit">Reply</a>
        <a href="#" class="action-link action-delete">Delete</a>
    </div>
</td>

</tr>


<!-- ROW 5 -->

<tr
    class="critical-row"
    data-status="new"
    data-priority="critical"
    data-owner="assigned"
>

<td class="checkbox-cell">
    <input type="checkbox">
</td>

<td>
    <a href="#" class="ticket-link">
        22779
    </a>
</td>

<td>
    <a href="#" class="tracking">
        7LP-R4M-<br>
        6HNB
    </a>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-12</span>
        <span class="time">19:32:00</span>
    </div>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-13</span>
        <span class="time">11:40:41</span>
    </div>
</td>

<td>
    VESSELS<br>
    TRACKING
</td>

<td>
    NNPCL<br>
    COMMAND AND<br>
    CONTROL<br>
    CENTER
</td>

<td>
    <a href="#" class="ticket-link">
        VESSELS WITH AIS<br>
        INFRACTIONS<br>
        AS OF 12<br>
        AUGUST 2026
    </a>
</td>

<td>
    <span class="status-new">
        New
    </span>
</td>

<td>
    NIGERIAN<br>
    NAVY (VESSEL<br>
    TRACKING)
</td>

<td>
    August 12, 2026
</td>

<td>
    NNPCL<br>
    COMMAND<br>
    AND CONTROL<br>
    CENTER
</td>

<td></td>

<td></td>

<td>
    Deep Blue<br>
    Water
</td>

<td>
    <span class="priority">
        <span class="priority-flag"></span>
        Critical
    </span>
</td>

<td>
    <div class="action-links">
        <a href="#" class="action-link action-edit">Reply</a>
        <a href="#" class="action-link action-delete">Delete</a>
    </div>
</td>

</tr>


<!-- ROW 6 -->

<tr
    class="critical-row"
    data-status="new"
    data-priority="critical"
    data-owner="assigned"
>

<td class="checkbox-cell">
    <input type="checkbox">
</td>

<td>
    <a href="#" class="ticket-link">
        22778
    </a>
</td>

<td>
    <a href="#" class="tracking">
        DMX-DGD-<br>
        MZNT
    </a>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-12</span>
        <span class="time">08:25:24</span>
    </div>
</td>

<td>
    <div class="date-time">
        <span class="date">2026-08-12</span>
        <span class="time">10:46:53</span>
    </div>
</td>

<td>
    VESSELS<br>
    TRACKING
</td>

<td>
    NNPCL<br>
    COMMAND AND<br>
    CONTROL<br>
    CENTER
</td>

<td>
    <a href="#" class="ticket-link">
        VESSELS WITH AIS<br>
        INFRACTIONS
    </a>
</td>

<td>
    <span class="status-new">
        New
    </span>
</td>

<td>
    NIGERIAN<br>
    NAVY (VESSEL<br>
    TRACKING)
</td>

<td>
    August 12, 2026
</td>

<td>
    NNPCL<br>
    COMMAND<br>
    AND CONTROL<br>
    CENTER
</td>

<td></td>

<td></td>

<td>
    Deep Blue<br>
    Water
</td>

<td>
    <span class="priority">
        <span class="priority-flag"></span>
        Critical
    </span>
</td>

<td>
    <div class="action-links">
        <a href="#" class="action-link action-edit">Reply</a>
        <a href="#" class="action-link action-delete">Delete</a>
    </div>
</td>

</tr>

</tbody>

</table>

</div>


<!-- =========================================================
     FOOTER
========================================================= -->

<div class="datatable-footer">

    <div
        class="table-info"
        id="tableInfo"
    >
        Showing 1 to 6 of 20,980 entries
    </div>


    <div class="pagination">

        <button class="page-btn">
            ‹
        </button>

        <button class="page-btn active">
            1
        </button>

        <button class="page-btn">
            2
        </button>

        <button class="page-btn">
            3
        </button>

        <button class="page-btn">
            4
        </button>

        <button class="page-btn">
            5
        </button>

        <button class="page-btn">
            …
        </button>

        <button class="page-btn">
            2098
        </button>

        <button class="page-btn">
            ›
        </button>

    </div>

</div>

</div>

</section>

</main>

</div>


<script>

/* ============================================================
   LIGHT / DARK MODE
============================================================ */

const themeToggle =
    document.getElementById("themeToggle");

const themeIcon =
    document.getElementById("themeIcon");


function applyTheme(theme){

    if(theme === "dark"){

        document.body.classList.add("dark-mode");

        themeIcon.textContent = "☀";

        themeToggle.setAttribute(
            "aria-label",
            "Switch to light mode"
        );

        themeToggle.setAttribute(
            "title",
            "Switch to light mode"
        );

    }else{

        document.body.classList.remove("dark-mode");

        themeIcon.textContent = "☾";

        themeToggle.setAttribute(
            "aria-label",
            "Switch to dark mode"
        );

        themeToggle.setAttribute(
            "title",
            "Switch to dark mode"
        );

    }

}


/* ============================================================
   LOAD SAVED THEME
============================================================ */

const savedTheme =
    localStorage.getItem("nnpc-imra-theme");


if(savedTheme === "dark"){

    applyTheme("dark");

}else{

    applyTheme("light");

}


/* ============================================================
   THEME TOGGLE CLICK
============================================================ */

themeToggle.addEventListener(
    "click",
    function(event){

        event.preventDefault();

        event.stopPropagation();


        const darkMode =
            document.body.classList.contains(
                "dark-mode"
            );


        if(darkMode){

            applyTheme("light");

            localStorage.setItem(
                "nnpc-imra-theme",
                "light"
            );

        }else{

            applyTheme("dark");

            localStorage.setItem(
                "nnpc-imra-theme",
                "dark"
            );

        }

    }
);


/* ============================================================
   CURRENT DATE / TIME
============================================================ */

const currentDateElement =
    document.getElementById("currentDate");

const currentTimeElement =
    document.getElementById("currentTime");

const lastLoginTimeElement =
    document.getElementById("lastLoginTime");

const pageLoadTime = new Date();


function updatePageDateTime(){

    const now = new Date();


    const dateText =
        now.toLocaleDateString(
            "en-NG",
            {
                day:"2-digit",
                month:"short",
                year:"numeric"
            }
        );


    const timeText =
        now.toLocaleTimeString(
            "en-NG",
            {
                hour:"2-digit",
                minute:"2-digit",
                second:"2-digit",
                hour12:false
            }
        );


    currentDateElement.textContent =
        dateText;

    currentTimeElement.textContent =
        timeText;


    if(lastLoginTimeElement){

        lastLoginTimeElement.textContent =
            pageLoadTime.toLocaleString(
                "en-NG",
                {
                    day:"2-digit",
                    month:"short",
                    year:"numeric",
                    hour:"2-digit",
                    minute:"2-digit",
                    hour12:false
                }
            );

    }

}


updatePageDateTime();

setInterval(
    updatePageDateTime,
    1000
);


/* ============================================================
   ELEMENTS
============================================================ */

const searchInput =
    document.getElementById("tableSearch");

const ticketTable =
    document.getElementById("ticketTable");

const tableBody =
    ticketTable.querySelector("tbody");

let tableRows =
    Array.from(
        tableBody.querySelectorAll("tr")
    );

const filterButtons =
    document.querySelectorAll(".filter-btn");

const selectAll =
    document.getElementById("selectAll");

const deleteMultipleBtn =
    document.getElementById("deleteMultipleBtn");

const dateFrom =
    document.getElementById("dateFrom");

const dateTo =
    document.getElementById("dateTo");

const clearDate =
    document.getElementById("clearDate");

const filteredCount =
    document.getElementById("filteredCount");

const sidebar =
    document.getElementById("sidebar");

const main =
    document.querySelector(".main");

const menuToggleBtn =
    document.getElementById("menuToggleBtn");

const mobileMenuBtn =
    document.getElementById("mobileMenuBtn");

const sidebarOverlay =
    document.getElementById("sidebarOverlay");


/* ============================================================
   DESKTOP MENU
============================================================ */

menuToggleBtn.addEventListener(
    "click",
    function(){

        if(window.innerWidth > 1000){

            sidebar.classList.toggle("hidden");

            main.classList.toggle(
                "sidebar-hidden"
            );

        }

    }
);


/* ============================================================
   MOBILE MENU
============================================================ */

function openMobileMenu(){

    sidebar.classList.add("open");

    sidebar.classList.remove("hidden");

    sidebarOverlay.classList.add("show");

    document.body.classList.add("menu-open");

}


function closeMobileMenu(){

    sidebar.classList.remove("open");

    sidebar.classList.add("hidden");

    sidebarOverlay.classList.remove("show");

    document.body.classList.remove("menu-open");

}


mobileMenuBtn.addEventListener(
    "click",
    function(){

        if(
            sidebar.classList.contains("open")
        ){

            closeMobileMenu();

        }else{

            openMobileMenu();

        }

    }
);


sidebarOverlay.addEventListener(
    "click",
    closeMobileMenu
);


/* ============================================================
   SIDEBAR LINKS
============================================================ */

document.querySelectorAll(
    ".menu-item"
).forEach(
    function(item){

        item.addEventListener(
            "click",
            function(){

                if(
                    window.innerWidth <= 1000 &&
                    !item.classList.contains(
                        "dropdown-menu-item"
                    )
                ){

                    closeMobileMenu();

                }

            }
        );

    }
);


/* ============================================================
   REPORTS / MODULES DROPDOWNS
============================================================ */

document.querySelectorAll(
    ".dropdown-menu-item"
).forEach(
    function(item){

        item.addEventListener(
            "click",
            function(event){

                event.stopPropagation();


                const dropdownId =
                    item.getAttribute(
                        "data-dropdown"
                    );


                const dropdown =
                    document.getElementById(
                        dropdownId
                    );


                if(!dropdown){
                    return;
                }


                const wasOpen =
                    dropdown.classList.contains(
                        "show"
                    );


                document.querySelectorAll(
                    ".menu-dropdown"
                ).forEach(
                    function(menu){

                        menu.classList.remove(
                            "show"
                        );

                    }
                );


                document.querySelectorAll(
                    ".dropdown-menu-item .arrow"
                ).forEach(
                    function(arrow){

                        arrow.textContent =
                            "▾";

                    }
                );


                if(!wasOpen){

                    dropdown.classList.add(
                        "show"
                    );


                    const arrow =
                        item.querySelector(
                            ".arrow"
                        );


                    if(arrow){

                        arrow.textContent =
                            "▴";

                    }

                }

            }
        );

    }
);


/* ============================================================
   RESPONSIVE MENU STATE
============================================================ */

window.addEventListener(
    "resize",
    function(){

        if(window.innerWidth <= 1000){

            sidebar.classList.remove(
                "open"
            );

            sidebar.classList.add(
                "hidden"
            );

            sidebarOverlay.classList.remove(
                "show"
            );

            main.classList.add(
                "sidebar-hidden"
            );

        }else{

            sidebar.classList.remove(
                "open"
            );

            sidebar.classList.remove(
                "hidden"
            );

            sidebarOverlay.classList.remove(
                "show"
            );

            main.classList.remove(
                "sidebar-hidden"
            );

        }

    }
);


/* ============================================================
   INITIAL MOBILE STATE
============================================================ */

if(window.innerWidth <= 1000){

    sidebar.classList.add(
        "hidden"
    );

    sidebar.classList.remove(
        "open"
    );

    main.classList.add(
        "sidebar-hidden"
    );

}


/* ============================================================
   USER DROPDOWN
============================================================ */

const userMenuButton =
    document.getElementById(
        "userMenuButton"
    );

const userDropdown =
    document.getElementById(
        "userDropdown"
    );


userMenuButton.addEventListener(
    "click",
    function(event){

        event.stopPropagation();


        userMenuButton.classList.toggle(
            "open"
        );


        userDropdown.classList.toggle(
            "show"
        );

    }
);


document.addEventListener(
    "click",
    function(event){

        if(
            !userMenuButton.contains(
                event.target
            )
        ){

            userMenuButton.classList.remove(
                "open"
            );

            userDropdown.classList.remove(
                "show"
            );

        }

    }
);


/* ============================================================
   CREATE TICKET CATEGORY MODAL
============================================================ */

const createTicketButton =
    document.querySelector(
        ".btn-create"
    );

const ticketCategoryModal =
    document.getElementById(
        "ticketCategoryModal"
    );

const ticketCategoryClose =
    document.getElementById(
        "ticketCategoryClose"
    );

const ticketCategoryOptions =
    document.querySelectorAll(
        ".ticket-category-option"
    );


function openTicketCategoryModal(){

    ticketCategoryModal.classList.add(
        "show"
    );

    ticketCategoryModal.setAttribute(
        "aria-hidden",
        "false"
    );

    document.body.classList.add(
        "menu-open"
    );

}


function closeTicketCategoryModal(){

    ticketCategoryModal.classList.remove(
        "show"
    );

    ticketCategoryModal.setAttribute(
        "aria-hidden",
        "true"
    );

    document.body.classList.remove(
        "menu-open"
    );

}


createTicketButton.addEventListener(
    "click",
    openTicketCategoryModal
);


ticketCategoryClose.addEventListener(
    "click",
    closeTicketCategoryModal
);


ticketCategoryModal.addEventListener(
    "click",
    function(event){

        if(
            event.target ===
            ticketCategoryModal
        ){

            closeTicketCategoryModal();

        }

    }
);


ticketCategoryOptions.forEach(
    function(option){

        option.addEventListener(
            "click",
            function(){

                ticketCategoryOptions.forEach(
                    function(item){

                        item.classList.remove(
                            "selected"
                        );

                    }
                );


                option.classList.add(
                    "selected"
                );


                const selectedCategory =
                    option.getAttribute(
                        "data-category"
                    );


                ticketCategoryModal.dataset.selectedCategory =
                    selectedCategory;

            }
        );

    }
);


/* ============================================================
   ESCAPE KEY
============================================================ */

document.addEventListener(
    "keydown",
    function(event){

        if(
            event.key === "Escape"
        ){

            if(
                ticketCategoryModal.classList.contains(
                    "show"
                )
            ){

                closeTicketCategoryModal();

            }


            userMenuButton.classList.remove(
                "open"
            );

            userDropdown.classList.remove(
                "show"
            );

        }

    }
);


/* ============================================================
   CLEAN TEXT
============================================================ */

function cleanText(element){

    let text =
        element.innerText ||
        element.textContent ||
        "";


    return text
        .replace(/\r?\n|\r/g," ")
        .replace(/\s+/g," ")
        .trim();

}


/* ============================================================
   SEARCH TEXT
============================================================ */

function getRowSearchText(row){

    return cleanText(row)
        .toLowerCase();

}


/* ============================================================
   GET ROW DATE
============================================================ */

function getRowDate(row){

    const dateElement =
        row.children[3]
            .querySelector(".date");


    const dateText =
        dateElement
            ? dateElement.textContent.trim()
            : "";


    return normalizeDate(dateText);

}


/* ============================================================
   NORMALIZE DATE
============================================================ */

function normalizeDate(value){

    if(!value){
        return "";
    }


    value = value.trim();


    if(
        /^\d{4}-\d{2}-\d{2}$/.test(value)
    ){

        return value;

    }


    const parsed =
        new Date(value);


    if(
        Number.isNaN(
            parsed.getTime()
        )
    ){

        return "";

    }


    const year =
        parsed.getFullYear();


    const month =
        String(
            parsed.getMonth()+1
        ).padStart(2,"0");


    const day =
        String(
            parsed.getDate()
        ).padStart(2,"0");


    return `${year}-${month}-${day}`;

}


/* ============================================================
   DATE MATCH
============================================================ */

function dateMatches(row){

    const from =
        dateFrom.value;

    const to =
        dateTo.value;


    if(
        from === "" &&
        to === ""
    ){

        return true;

    }


    const rowDate =
        getRowDate(row);


    if(rowDate === ""){

        return false;

    }


    if(
        from !== "" &&
        to === ""
    ){

        return rowDate >= from;

    }


    if(
        from === "" &&
        to !== ""
    ){

        return rowDate <= to;

    }


    return(
        rowDate >= from &&
        rowDate <= to
    );

}


/* ============================================================
   VALIDATE DATE RANGE
============================================================ */

function validateDateRange(){

    if(
        dateFrom.value !== "" &&
        dateTo.value !== "" &&
        dateFrom.value > dateTo.value
    ){

        dateTo.setCustomValidity(
            "The To date cannot be earlier than the From date."
        );

        return false;

    }


    dateTo.setCustomValidity("");

    return true;

}


/* ============================================================
   APPLY FILTERS
============================================================ */

function applyFilters(){

    if(
        !validateDateRange()
    ){

        return;

    }


    const search =
        searchInput.value
            .trim()
            .toLowerCase();


    const activeFilter =
        document
            .querySelector(
                ".filter-btn.active"
            )
            .dataset.filter;


    let visibleCount = 0;


    tableRows.forEach(
        function(row){

            const rowText =
                getRowSearchText(row);


            let filterMatch = true;


            if(
                activeFilter === "new"
            ){

                filterMatch =
                    row.dataset.status ===
                    "new";

            }


            if(
                activeFilter === "opened"
            ){

                filterMatch =
                    row.dataset.status ===
                    "opened";

            }


            if(
                activeFilter === "in-progress"
            ){

                filterMatch =
                    row.dataset.status ===
                    "in-progress";

            }


            if(
                activeFilter === "replied"
            ){

                filterMatch =
                    row.dataset.status ===
                    "replied";

            }


            if(
                activeFilter === "resolved"
            ){

                filterMatch =
                    row.dataset.status ===
                    "resolved";

            }


            const searchMatch =
                search === "" ||
                rowText.includes(search);


            const rowDateMatch =
                dateMatches(row);


            const show =
                filterMatch &&
                searchMatch &&
                rowDateMatch;


            row.style.display =
                show ? "" : "none";


            if(show){

                visibleCount++;

            }

        }
    );


    updateTableInfo(
        visibleCount,
        search
    );


    filteredCount.textContent =
        visibleCount;


    updateSelectAllState();

}


/* ============================================================
   TABLE INFORMATION
============================================================ */

function updateTableInfo(
    visibleCount,
    search
){

    const tableInfo =
        document.getElementById(
            "tableInfo"
        );


    const hasDateFilter =
        dateFrom.value !== "" ||
        dateTo.value !== "";


    if(
        search !== "" ||
        hasDateFilter
    ){

        tableInfo.textContent =
            `Showing ${visibleCount} matching entries`;

    }else{

        tableInfo.textContent =
            `Showing 1 to ${visibleCount} of 20,980 entries`;

    }

}


/* ============================================================
   SEARCH EVENTS
============================================================ */

searchInput.addEventListener(
    "input",
    applyFilters
);


dateFrom.addEventListener(
    "change",
    function(){

        validateDateRange();

        applyFilters();

    }
);


dateTo.addEventListener(
    "change",
    function(){

        validateDateRange();

        applyFilters();

    }
);


clearDate.addEventListener(
    "click",
    function(){

        dateFrom.value = "";

        dateTo.value = "";

        validateDateRange();

        applyFilters();

    }
);


/* ============================================================
   FILTER BUTTONS
============================================================ */

filterButtons.forEach(
    function(button){

        button.addEventListener(
            "click",
            function(){

                filterButtons.forEach(
                    function(btn){

                        btn.classList.remove(
                            "active"
                        );

                    }
                );


                this.classList.add(
                    "active"
                );


                applyFilters();

            }
        );

    }
);


/* ============================================================
   SELECT ALL
============================================================ */

selectAll.addEventListener(
    "change",
    function(){

        tableRows.forEach(
            function(row){

                if(
                    row.style.display ===
                    "none"
                ){

                    return;

                }


                const checkbox =
                    row.querySelector(
                        'input[type="checkbox"]'
                    );


                if(checkbox){

                    checkbox.checked =
                        selectAll.checked;

                }

            }
        );

    }
);


/* ============================================================
   KEEP SELECT ALL STATE ACCURATE
============================================================ */

function updateSelectAllState(){

    const visibleRows =
        tableRows.filter(
            row =>
                row.style.display !== "none"
        );


    const visibleCheckboxes =
        visibleRows
            .map(
                row =>
                    row.querySelector(
                        'input[type="checkbox"]'
                    )
            )
            .filter(Boolean);


    if(
        visibleCheckboxes.length === 0
    ){

        selectAll.checked = false;

        selectAll.indeterminate = false;

        return;

    }


    const checkedCount =
        visibleCheckboxes.filter(
            checkbox =>
                checkbox.checked
        ).length;


    selectAll.checked =
        checkedCount ===
        visibleCheckboxes.length;


    selectAll.indeterminate =
        checkedCount > 0 &&
        checkedCount <
        visibleCheckboxes.length;

}


/* ============================================================
   INDIVIDUAL CHECKBOXES
============================================================ */

function attachCheckboxEvents(){

    tableRows.forEach(
        function(row){

            const checkbox =
                row.querySelector(
                    'input[type="checkbox"]'
                );


            if(
                checkbox &&
                !checkbox.dataset.listenerAttached
            ){

                checkbox.dataset.listenerAttached =
                    "true";


                checkbox.addEventListener(
                    "change",
                    updateSelectAllState
                );

            }

        }
    );

}


attachCheckboxEvents();


/* ============================================================
   INDIVIDUAL DELETE
============================================================ */

function deleteRow(row){

    if(!row){
        return;
    }


    const ticketIdElement =
        row.querySelector(
            ".ticket-link"
        );


    const ticketId =
        ticketIdElement
            ? cleanText(ticketIdElement)
            : "this ticket";


    const confirmed =
        confirm(
            `Are you sure you want to delete ticket ${ticketId}?`
        );


    if(!confirmed){
        return;
    }


    row.remove();


    tableRows =
        Array.from(
            tableBody.querySelectorAll("tr")
        );


    selectAll.checked = false;

    selectAll.indeterminate = false;


    applyFilters();

}


/* ============================================================
   REPLY / DELETE ACTION LINKS
============================================================ */

tableBody.addEventListener(
    "click",
    function(event){

        const deleteLink =
            event.target.closest(
                ".action-delete"
            );


        const replyLink =
            event.target.closest(
                ".action-edit"
            );


        if(deleteLink){

            event.preventDefault();

            const row =
                deleteLink.closest("tr");


            deleteRow(row);

            return;

        }


        if(replyLink){

            event.preventDefault();

            const row =
                replyLink.closest("tr");


            const ticketIdElement =
                row
                    ? row.querySelector(
                        ".ticket-link"
                    )
                    : null;


            const ticketId =
                ticketIdElement
                    ? cleanText(ticketIdElement)
                    : "";


            alert(
                `Reply to ticket ${ticketId}`
            );

        }

    }
);


/* ============================================================
   DELETE MULTIPLE
============================================================ */

deleteMultipleBtn.addEventListener(
    "click",
    function(){

        const selectedRows =
            tableRows.filter(
                function(row){

                    const checkbox =
                        row.querySelector(
                            'input[type="checkbox"]'
                        );


                    return checkbox &&
                        checkbox.checked;

                }
            );


        if(
            selectedRows.length === 0
        ){

            alert(
                "Please select at least one ticket to delete."
            );

            return;

        }


        const confirmed =
            confirm(
                `Are you sure you want to delete ${selectedRows.length} selected ticket${selectedRows.length > 1 ? "s" : ""}?`
            );


        if(!confirmed){
            return;
        }


        selectedRows.forEach(
            function(row){

                row.remove();

            }
        );


        tableRows =
            Array.from(
                tableBody.querySelectorAll("tr")
            );


        selectAll.checked = false;

        selectAll.indeterminate = false;


        applyFilters();

    }
);


/* ============================================================
   AUTO RELOAD
============================================================ */

const reloadCheckbox =
    document.querySelector(
        ".reload input"
    );


const reloadText =
    document.getElementById(
        "reloadText"
    );


let reloadSeconds = 49;


setInterval(
    function(){

        if(
            !reloadCheckbox.checked
        ){

            return;

        }


        reloadSeconds--;


        if(
            reloadSeconds <= 0
        ){

            /*
             * Connect AJAX reload here.
             *
             * Example:
             *
             * loadTickets();
             *
             * Current search and filter
             * state remains untouched.
             */

            reloadSeconds = 49;

        }


        reloadText.textContent =
            `Auto reload page (${reloadSeconds})`;

    },
    1000
);


/* ============================================================
   INITIAL STATE
============================================================ */

applyFilters();

</script>

</body>

</html>