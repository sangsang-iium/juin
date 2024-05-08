 <script src="https://js.tosspayments.com/v1/brandpay"></script>

<script>
  var clientKey = 'test_ck_D5GePWvyJnrK0W0k6q8gLzN97Eoq' // 테스트용 클라이언트 키
  var customerKey = '{CUSTOMER_KEY}' // 구매자 ID
  // ...

  // BrandPay 객체 초기화
  var brandpay = BrandPay(clientKey, customerKey, {
    redirectUrl: 'https://juin.eumsvr.com/m/shop/test.php'
  })
</script>

<script>
  const orderId = "123123123";
  function requestPayment() {
    brandpay.requestPayment({
      amount: 5000, // 결제 금액
      orderId: orderId, // 주문에 대한 고유한 ID 값
      orderName: '토스 티셔츠 외 2건', // 결제에 대한 구매상품
    })
  }
</script>

<button onclick="requestPayment()">결제하기</button>