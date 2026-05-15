<!-- footer.php -->
<style>
  /* ── 퐁퐁코리아 푸터 ── */
  .pk-footer {
    background: #1E293B;
    color: #94A3B8;
    padding: 40px 20px 0;
    font-size: 13px;
    line-height: 1.7;
    margin-top: auto;
  }
  .pk-footer-wrap {
    max-width: 1160px;
    margin: 0 auto;
  }
  .pk-footer-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 28px;
    padding-bottom: 32px;
    border-bottom: 1px solid #334155;
  }
  @media (min-width: 600px) {
    .pk-footer-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (min-width: 900px) {
    .pk-footer-grid { grid-template-columns: 2fr 1.2fr 1fr; }
  }

  /* 브랜드 열 */
  .pk-ft-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    font-weight: 900;
    color: #F1F5F9;
    margin-bottom: 8px;
    letter-spacing: -.3px;
  }
  .pk-ft-brand-icon {
    width: 26px;
    height: 26px;
    background: #3730A3;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
  }
  .pk-ft-tagline {
    font-size: 12px;
    color: #64748B;
    margin-bottom: 14px;
  }
  .pk-ft-biz {
    font-size: 11.5px;
    color: #475569;
    line-height: 1.9;
  }

  /* 섹션 타이틀 */
  .pk-footer-col h3 {
    font-size: 11px;
    font-weight: 700;
    color: #CBD5E1;
    margin-bottom: 12px;
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  /* 링크 목록 */
  .pk-ft-list {
    list-style: none;
    padding: 0;
    margin: 0 0 10px;
  }
  .pk-ft-list li {
    margin-bottom: 7px;
  }
  .pk-ft-list a {
    color: #94A3B8;
    text-decoration: none;
    transition: color .15s;
  }
  .pk-ft-list a:hover { color: #A5B4FC; }
  .pk-ft-note {
    font-size: 11px;
    color: #475569;
    margin-top: 8px;
    line-height: 1.6;
  }

  /* 하단 바 */
  .pk-ft-bottom {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 6px;
    padding: 16px 0;
    font-size: 11.5px;
    color: #475569;
  }
</style>

<footer class="pk-footer">
  <div class="pk-footer-wrap">
    <div class="pk-footer-grid">

      <!-- 회사 정보 -->
      <div class="pk-footer-col">
        <div class="pk-ft-brand">
          <span class="pk-ft-brand-icon">🔍</span>
          퐁퐁코리아
        </div>
        <p class="pk-ft-tagline">퐁퐁 터지는 생활시설 정보</p>
        <p class="pk-ft-biz">
          문딜로지스틱스 (MoonDilogistics)<br>
          사업자 등록번호: 345-18-02361<br>
          IT 웹 서비스 운영
        </p>
      </div>

      <!-- 고객센터 -->
      <div class="pk-footer-col">
        <h3>고객센터</h3>
        <ul class="pk-ft-list">
          <li>📧 <a href="mailto:gjqmaoslwj@naver.com">gjqmaoslwj@naver.com</a></li>
          <li>⏰ 평일 09:00 ~ 18:00</li>
          <li>🕛 점심시간 11:00 ~ 13:00</li>
        </ul>
        <p class="pk-ft-note">정보 오류 수정 · 삭제 요청 · 이용 문의</p>
      </div>

      <!-- 서비스 -->
      <div class="pk-footer-col">
        <h3>서비스</h3>
        <ul class="pk-ft-list">
          <li>🔍 <a href="/">퐁퐁코리아</a></li>
          <li>💼 <a href="#">편잇 - 차량 할인 정보</a></li>
        </ul>
      </div>

    </div>

    <div class="pk-ft-bottom">
      <span>© 2024 문딜로지스틱스. All rights reserved.</span>
      <span>공공데이터 기반 생활시설 정보 포털</span>
    </div>
  </div>
</footer>

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
if (window.location.hostname !== "localhost" && window.location.hostname !== "127.0.0.1") {
    if (!wcs_add) var wcs_add = {};
    wcs_add["wa"] = "118e129bfaa8a90";
    if (window.wcs) { wcs_do(); }
}
</script>
