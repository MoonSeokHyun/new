<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,follow">
    <title>페이지를 찾을 수 없습니다 | 퐁퐁코리아</title>
    <meta name="description" content="요청하신 페이지를 찾을 수 없습니다. 전국 미용실·도서관·안경점·동물병원·캠핑장·체육시설 등 생활시설 정보는 아래 카테고리에서 확인하세요.">
    <style>
        :root {
            --accent:#62D491; --accent-dark:#3eaf7c; --bg:#f9fafb; --card:#fff;
            --text:#1f2937; --muted:#6b7280; --border:#e5e7eb;
        }
        * { box-sizing:border-box; }
        body { margin:0; font-family:'Pretendard','Segoe UI',Arial,sans-serif; background:var(--bg); color:var(--text); -webkit-font-smoothing:antialiased; }
        .wrap { max-width:960px; margin:0 auto; padding:48px 20px 24px; text-align:center; }
        .badge { display:inline-block; padding:6px 14px; background:#e6f7ef; color:var(--accent-dark); border-radius:999px; font-weight:600; font-size:14px; letter-spacing:.5px; }
        h1 { font-size:3.2rem; margin:18px 0 8px; letter-spacing:-1px; }
        h1 span { color:var(--accent-dark); }
        .lead { color:var(--muted); font-size:1.05rem; line-height:1.7; margin:0 auto 8px; max-width:560px; }
        .hint { color:#9ca3af; font-size:.9rem; margin-bottom:24px; }
        .cta-row { display:flex; gap:10px; justify-content:center; flex-wrap:wrap; margin-bottom:28px; }
        .cta { display:inline-flex; align-items:center; gap:6px; padding:12px 20px; border-radius:10px; text-decoration:none; font-weight:600; font-size:15px; transition:transform .15s ease, box-shadow .15s ease; }
        .cta.primary { background:var(--accent); color:#fff; }
        .cta.primary:hover { transform:translateY(-1px); box-shadow:0 6px 14px rgba(98,212,145,.35); }
        .cta.ghost { background:#fff; color:var(--text); border:1px solid var(--border); }
        .cta.ghost:hover { border-color:var(--accent); color:var(--accent-dark); }
        .grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:12px; max-width:880px; margin:8px auto 0; padding:0 8px; }
        .chip { display:flex; align-items:center; gap:10px; padding:14px 16px; background:var(--card); border:1px solid var(--border); border-radius:12px; text-decoration:none; color:var(--text); font-weight:600; transition:border-color .15s ease, transform .15s ease, box-shadow .15s ease; }
        .chip:hover { border-color:var(--accent); transform:translateY(-2px); box-shadow:0 4px 12px rgba(0,0,0,.06); }
        .chip .ico { font-size:1.3rem; }
        .foot-tip { margin-top:36px; color:#9ca3af; font-size:.85rem; }
        @media (max-width:600px) { h1 { font-size:2.4rem; } .wrap { padding-top:32px; } }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="badge">404 NOT FOUND</div>
        <h1>원하시는 페이지를 <span>찾지 못했어요</span></h1>
        <p class="lead">주소가 변경되었거나 삭제된 페이지일 수 있습니다. 아래 카테고리에서 필요한 생활 정보를 바로 확인해 보세요.</p>
        <p class="hint">퐁퐁코리아는 공공데이터 기반 전국 생활시설 정보를 제공합니다.</p>

        <div class="cta-row">
            <a class="cta primary" href="/">🏠 홈으로 이동</a>
            <a class="cta ghost" href="/hairsalon">미용실 찾기</a>
            <a class="cta ghost" href="/camping">캠핑장 찾기</a>
        </div>

        <div class="grid">
            <a class="chip" href="/hairsalon"><span class="ico">💇</span>미용실</a>
            <a class="chip" href="/library-info"><span class="ico">📚</span>도서관</a>
            <a class="chip" href="/open-service-info"><span class="ico">👓</span>안경점</a>
            <a class="chip" href="/animal-hospital"><span class="ico">🐶</span>동물병원</a>
            <a class="chip" href="/camping"><span class="ico">🏕️</span>캠핑장</a>
            <a class="chip" href="/sports-facility"><span class="ico">🏟️</span>체육시설</a>
            <a class="chip" href="/world-res"><span class="ico">🌍</span>세계음식</a>
            <a class="chip" href="/seminar-rooms"><span class="ico">🏢</span>공유회의실</a>
            <a class="chip" href="/installation"><span class="ico">💊</span>폐의약품</a>
            <a class="chip" href="/clothing-collection-bin"><span class="ico">👕</span>의류 수거함</a>
        </div>

        <?php if (ENVIRONMENT !== 'production' && isset($message)) : ?>
            <pre style="text-align:left;white-space:pre-wrap;color:#9ca3af;font-size:.8rem;margin-top:32px;"><?= nl2br(esc($message)) ?></pre>
        <?php endif; ?>

        <p class="foot-tip">© 퐁퐁코리아</p>
    </div>
</body>
</html>
