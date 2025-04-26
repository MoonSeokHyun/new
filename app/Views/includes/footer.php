<!-- footer.php -->
<footer>
  <div class="footer-container">
    <!-- 회사 정보 -->
    <div class="footer-section">
      <h3>문딜로지스틱스 (MoonDilogistics)</h3>
      <p>IT 웹 서비스 운영</p>
      <p>사업자 등록번호 : 345-18-02361</p>
      <p class="copyright">
        © Copyright Since 2024 문딜로지스틱스. All rights reserved.
      </p>
    </div>
    <!-- 고객센터 -->
    <div class="footer-section">
      <h3>고객센터</h3>
      <p>이메일: <a href="mailto:gjqmaoslwj@naver.com">gjqmaoslwj@naver.com</a></p>
      <p>운영시간: 평일 09:00 ~ 18:00 (점심시간 11:00 ~ 13:00)</p>
      <p class="footer-note">홈페이지 정보 오류 수정 / 삭제 요청 / 이용 문의 등</p>
    </div>
    <!-- 사이드 프로젝트 -->
    <div class="footer-section">
      <h3>Side Projects</h3>
      <ul>
        <li><a href="#">🔍생활정도보는 퐁퐁 터지는 퐁퐁코리아 </a></li>
        <li><a href="#">💼각종 할인 차량정보는 편잇!</a></li>
      </ul>
    </div>
  </div>
</footer>

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
if (window.location.hostname !== "localhost" && window.location.hostname !== "127.0.0.1") {
    // 로컬 환경이 아니면 카운팅을 수행
    if (!wcs_add) var wcs_add = {};
    wcs_add["wa"] = "118e129bfaa8a90";
    if (window.wcs) {
        wcs_do();
    }
}
</script>


<!-- 스타일 -->
<style>
  footer {
    background-color: #f8f9fa;
    color: #333;
    padding: 40px 20px;
    border-top: 1px solid #ddd;
    font-size: 14px;
  }
  .footer-container {
    display: flex;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: 0 auto;
    gap: 40px;
    justify-content: space-between;
  }
  .footer-section {
    flex: 1 1 120px;
    min-width: 250px;
  }
  .footer-section h3 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #111;
  }
  .footer-section p,
  .footer-section li {
    margin: 6px 0;
    line-height: 1.6;
  }
  .footer-section a {
    color: #0066cc;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .footer-section a:hover {
    text-decoration: underline;
    color: #004999;
  }
  .footer-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .footer-note {
    color: #666;
    font-size: 13px;
    margin-top: 10px;
  }
  .copyright {
    margin-top: 20px;
    font-size: 12px;
    color: #888;
  }
</style>
