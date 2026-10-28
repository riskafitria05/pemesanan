<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,800&display=swap" rel="stylesheet">
<style>
:root{--pine:#12403a;--pine-2:#1c5a52;--saffron:#f2b705;--bg:#f2f5f3;--card:#fff;--ink:#17211f;--muted:#5d6b67;--line:#d5ddd9;--bad:#b3261e;--ok:#1a7a3c}
*{box-sizing:border-box}
html{-webkit-text-size-adjust:100%}
body{margin:0;background:var(--bg);color:var(--ink);font:16px/1.55 'Bricolage Grotesque',system-ui,-apple-system,'Segoe UI',sans-serif}
a{color:var(--pine-2)}
h1,h2,h3{line-height:1.15;margin:0 0 .6rem;letter-spacing:-.01em}
h1{font-size:2rem;font-weight:800}h2{font-size:1.35rem;font-weight:600}h3{font-size:1.05rem;font-weight:600}
.wrap{max-width:1080px;margin:0 auto;padding:0 1.1rem}
header.top{background:var(--pine);color:#fff}
header.top .wrap{display:flex;align-items:center;gap:1.4rem;min-height:60px;flex-wrap:wrap;padding-top:.4rem;padding-bottom:.4rem}
header.top .brand{font-weight:800;font-size:1.25rem;color:#fff;text-decoration:none;margin-right:auto}
header.top .brand span{color:var(--saffron)}
header.top nav{display:flex;gap:1.1rem;align-items:center;flex-wrap:wrap}
header.top nav a,header.top nav button.link{color:#e6efec;text-decoration:none;font:inherit;background:none;border:0;cursor:pointer;padding:.25rem 0;border-bottom:2px solid transparent}
header.top nav a:hover,header.top nav a.on,header.top nav button.link:hover{color:#fff;border-bottom-color:var(--saffron)}
main{padding:1.6rem 0 3rem}
.card{background:var(--card);border:1px solid var(--line);border-radius:10px;padding:1.2rem}
.grid{display:grid;gap:1rem;grid-template-columns:repeat(auto-fill,minmax(230px,1fr))}
.menu-card{display:flex;flex-direction:column;padding:0;overflow:hidden}
.menu-card .img{aspect-ratio:4/3;background:#dfe8e4 center/cover;display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:.9rem}
.menu-card .body{padding:.9rem 1rem 1rem;display:flex;flex-direction:column;gap:.35rem;flex:1}
.menu-card .price{font-weight:800;font-size:1.1rem}
.menu-card form{margin-top:auto;display:flex;gap:.5rem}
.muted{color:var(--muted);font-size:.92rem}
.tag{display:inline-block;font-size:.8rem;padding:.1rem .55rem;border-radius:99px;background:#e3ece8;color:var(--pine)}
label{display:block;font-weight:600;margin:.8rem 0 .25rem}
input,select,textarea{width:100%;font:inherit;padding:.55rem .7rem;border:1px solid #b9c6c1;border-radius:7px;background:#fff;color:var(--ink)}
input:focus,select:focus,textarea:focus,.btn:focus-visible,a:focus-visible,button:focus-visible{outline:3px solid var(--saffron);outline-offset:1px}
input[type=number]{width:5.2rem}
.btn{display:inline-block;font:inherit;font-weight:600;padding:.55rem 1.05rem;border-radius:7px;border:1px solid var(--pine);background:var(--pine);color:#fff;text-decoration:none;cursor:pointer}
.btn:hover{background:var(--pine-2)}
.btn.alt{background:var(--saffron);border-color:var(--saffron);color:#2a2000}
.btn.alt:hover{background:#ffc928}
.btn.ghost{background:#fff;color:var(--pine)}
.btn.ghost:hover{background:#eef3f1}
.btn.bad{background:var(--bad);border-color:var(--bad)}
.btn.sm{padding:.3rem .65rem;font-size:.9rem}
table{width:100%;border-collapse:collapse;background:#fff;border:1px solid var(--line);border-radius:10px;overflow:hidden}
th,td{padding:.65rem .8rem;text-align:left;border-bottom:1px solid var(--line);vertical-align:top}
th{background:#e9f0ed;font-weight:600;font-size:.92rem}
tr:last-child td{border-bottom:0}
td.num,th.num{text-align:right;white-space:nowrap}
.scroll{overflow-x:auto}
.flash{padding:.7rem 1rem;border-radius:8px;margin-bottom:1rem;border:1px solid}
.flash.success{background:#e5f4ea;border-color:#a8d5b6;color:#14532d}
.flash.error{background:#fdeceb;border-color:#f0b5b1;color:#7a1712}
.badge{display:inline-block;padding:.1rem .6rem;border-radius:99px;font-size:.85rem;font-weight:600;background:#e3e8e6;color:#33403c;white-space:nowrap}
.badge.menunggu,.badge.belum_bayar,.badge.menunggu_verifikasi{background:#fff1c2;color:#6b4e00}
.badge.diproses{background:#d8e8fb;color:#12407a}
.badge.selesai,.badge.terverifikasi{background:#d4efdc;color:#14532d}
.badge.dibatalkan,.badge.ditolak{background:#f8d9d6;color:#7a1712}
.bar{display:flex;gap:.6rem;flex-wrap:wrap;align-items:end;margin-bottom:1.1rem}
.bar>*{flex:0 1 auto}.bar .grow{flex:1 1 220px}
.bar label{margin:0 0 .25rem}
.row{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:1rem}
.cols{display:grid;gap:1.1rem;grid-template-columns:1fr 1fr}
@media(max-width:760px){.cols{grid-template-columns:1fr}h1{font-size:1.6rem}}
.stat{font-size:1.9rem;font-weight:800}
.err{color:var(--bad);font-size:.9rem;margin-top:.2rem}
.thumb{width:48px;height:48px;border-radius:6px;object-fit:cover;background:#dfe8e4;display:block}
.login{max-width:380px;margin:3rem auto}
.bukti{max-width:100%;max-height:360px;border:1px solid var(--line);border-radius:8px}
@media(prefers-reduced-motion:no-preference){.btn{transition:background .15s}}
</style>
