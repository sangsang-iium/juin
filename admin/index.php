<?php
define('NO_CONTAINER', true);
include_once("./_common.php");
include_once(BV_ADMIN_PATH."/admin_access.php");
include_once(BV_ADMIN_PATH."/admin_head.php");
include_once(BV_ADMIN_PATH."/admin_topmenu.php");

$sodrr = admin_order_status_sum("where dan > 0 "); // 총 주문내역
$sodr1 = admin_order_status_sum("where dan = 1 "); // 총 입금대기
$sodr2 = admin_order_status_sum("where dan = 2 "); // 총 입금완료
$sodr3 = admin_order_status_sum("where dan = 3 "); // 총 배송준비
$sodr4 = admin_order_status_sum("where dan = 4 "); // 총 배송중
$sodr5 = admin_order_status_sum("where dan = 5 "); // 총 배송완료
$sodr6 = admin_order_status_sum("where dan = 6 "); // 총 입금전 취소
$sodr7 = admin_order_status_sum("where dan = 7 "); // 총 배송후 반품
$sodr8 = admin_order_status_sum("where dan = 8 "); // 총 배송후 교환
$sodr9 = admin_order_status_sum("where dan = 9 "); // 총 배송전 환불
$final = admin_order_status_sum("where dan = 5 and user_ok = 0 "); // 총 구매미확정
?>


<div id="main_dashboard">
    <div class="dashboard_boxs">
        <dl>
            <dt class="box_title">금일 주문현황</dt>
            <dd class="box_contents">
                <div class="box_white">
                    <p class="content_title">주문</p>
                    <div class="cnt_data_box">
                        <p class="total_boxs">
                            <?php echo number_format($sodrr['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                        <p class="data_bot">
                            <?php echo number_format($sodrr['price']); ?>
                            <span class="cnt_unit_text">원</span>
                        </p>
                    </div>
                </div>       
                <div class="box_white">
                    <p class="content_title color_type1">취소</p>
                    <div class="cnt_data_box">
                        <p class="total_boxs color_type1">
                            <?php echo number_format($sodr6['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                        <p class="data_bot">
                            5,201,800
                            <span class="cnt_unit_text">원</span>
                        </p>
                    </div>
                </div>       
            </dd>
        </dl>
        <dl>
            <dt class="box_title select_type">
                매출현황(당월)
                <div class="chk_select">
                    <select name="" id="order_month">
                        <option value="0">1월</option>
                        <option value="1">2월</option>
                        <option value="2">3월</option>
                        <option value="3">4월</option>
                        <option value="4">5월</option>
                        <option value="5" selected>6월</option>
                    </select>
                </div>
            </dt>
            <dd class="box_contents line_box">
                <div class="order_line_cnt box_white">
                    <p class="content_title">결제완료</p>
                    <div class="approval_box">
                        <p class="order_line_num">
                            <span id="order_data_check1">3,580</span>
                            <span class="cnt_unit_text">건</span>
                        </p>
                        <p class="order_line_money">
                            <span id="order_data_money1">121,712,000</span>
                            <span class="cnt_unit_text">원</span>
                        </p>
                    </div>
                </div>
                <div class="order_line_cnt box_white">
                    <p class="content_title color_type3">미결재</p>
                    <ul class="order_line_wrap">
                        <li>
                            <p class="normal_order">일반</p>
                            <div class="approval_box">
                                <p class="order_line_num color_type3">
                                    <span id="order_data_check2">34</span>
                                    <span class="cnt_unit_text">건</span>
                                </p>
                                <p class="order_line_money">
                                    <span id="order_data_money2">575,000</span>
                                    <span class="cnt_unit_text">원</span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <p class="regular_order">정기</p>
                            <div class="approval_box">
                                <p class="order_line_num color_type3">
                                <span id="order_data_check3">45</span>
                                    <span class="cnt_unit_text">건</span>
                                </p>
                                <p class="order_line_money">
                                    <span id="order_data_money3">845,000</span>
                                    <span class="cnt_unit_text">원</span>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="order_line_cnt box_white">
                    <p class="content_title color_type2">합계</p>
                    <div class="approval_box">
                        <p class="order_line_num color_type2">
                            <span id="order_data_check4">3,659</span>
                            <span>건</span>
                        </p>
                        <p class="order_line_money">
                            <span id="order_data_money4">123,132,000</span>
                            <span class="cnt_unit_text">원</span>
                        </p>
                    </div>
                </div>
            </dd>
        </dl>
        <dl class="flex_fixed">
            <dt class="box_title link_type">
                <a href="#">매출순위(당월)</a>
            </dt>
            <dd class="box_contents rank_type">
                <div class="box_white">
                    <p class="content_title color_type2 none_bd">직할지회</p>
                    <ol>
                        <li>
                            <p class="rank_name">은평구지회</p>
                            <p class="rank_money color_type2">
                                10,250,000
                                <span class="cnt_unit_text">원</span>
                            </p>
                        </li>
                        <li>
                            <p class="rank_name">강동구지회</p>
                            <p class="rank_money color_type2">9,002,100
                                <span class="cnt_unit_text">원</span></p>
                        </li>
                        <li>
                            <p class="rank_name">강서구지회</p>
                            <p class="rank_money color_type2">8,305,000
                                <span class="cnt_unit_text">원</span></p>
                        </li>
                        <li>
                            <p class="rank_name">성북구지회</p>
                            <p class="rank_money color_type2">7,562,000
                                <span class="cnt_unit_text">원</span></p>
                        </li>
                        <li>
                            <p class="rank_name">강남구지회</p>
                            <p class="rank_money color_type2">6,050,000
                                <span class="cnt_unit_text">원</span></p>
                        </li>
                    </ol>
                </div>       
                <div class="box_white">
                    <p class="content_title color_type3 none_bd">시도지회</p>
                    <ol>
                        <li>
                            <p class="rank_name">경기북부지회</p>
                            <p class="rank_money color_type3">20,040,100
                                <span class="cnt_unit_text">원</span></p>
                        </li>
                        <li>
                            <p class="rank_name">경기남부지회</p>
                            <p class="rank_money color_type3">19,430,200
                                <span class="cnt_unit_text">원</span></p>
                        </li>
                        <li>
                            <p class="rank_name">경상북도지회</p>
                            <p class="rank_money color_type3">17,065,000
                                <span class="cnt_unit_text">원</span></p>
                        </li>
                        <li>
                            <p class="rank_name">경상남도지회</p>
                            <p class="rank_money color_type3">16,054,000
                                <span class="cnt_unit_text">원</span></p>
                        </li>
                        <li>
                            <p class="rank_name">강원도지회</p>
                            <p class="rank_money color_type3">15,505,000
                                <span class="cnt_unit_text">원</span></p>
                        </li>
                    </ol>
                </div>       
            </dd>
        </dl>
        <dl>
            <dt class="box_title link_type">
                <a href="#">최근 등록된 상품</a>
            </dt>
            <dd class="box_contents rank_type new_item_list">
                <ol class="box_white">
                    <li>
                        <a href="#" class="new_item_name">수미안 들기름(1.8L/3병)_택배_허브</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">수미안 볶음참깨(1kg*6개 제주)_허브</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">새댁표고추맛기름(남양유지/3.4L)EA</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">(매운_중식용)수미안 중국산 고춧가루(1kg*5개 중국산)_제주</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">수미안 중국산 건고추(1kg*3개)_제주</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">포기김치(강동)10KG</a>
                    </li>
                </ol>          
            </dd>
        </dl>
    </div>
    <div class="dashboard_boxs">
        <div class="dashboard_graph">
            <dl>
                <dt class="box_title">주문실적현황</dt>
                <dd class="box_contents">
                    <div class="chart_box box_white">
                        <div id="chart" style="width:100%;"></div>
                    </div>
                </dd>
            </dl>
        </div>
        <div class="dashboard_boards">
            <dl>
                <dt class="box_title link_type">
                    <a href="#">
                        공지사항
                    </a>    
                </dt>
                <dd class="box_contents">
                    <ul class="box_white board_list">
                        <li>
                            <a href="#" class="board_title">(매운_중식용)수미안 중국산 고춧가루(1kg*5개 중국산)_제주 판매종료</a>
                            <span class="board_date">2024-06-12</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">신규 회원가입 이벤트</a>
                            <span class="board_date">2024-06-05</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">6월 연휴 주문 및 배송 안내</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">환불 규정 안내</a>
                            <span class="board_date">2024-05-15</span>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt class="box_title link_type">
                    <a href="#">
                        1대1 문의
                    </a>
                </dt>
                <dd class="box_contents">
                    <ul class="box_white board_list">
                        <li>
                            <a href="#" class="board_title">환불 신청합니다.</a>
                            <span class="board_date">2024-06-22</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">배송 언제 오는지 알수 있을까요?</a>
                            <span class="board_date">2024-06-22</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">언제 다시 상품이 입고 되나요?</a>
                            <span class="board_date">2024-06-21</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">배송 기간이 궁금합니다.</a>
                            <span class="board_date">2024-06-21</span>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt class="box_title link_type">
                    <a href="<?php echo BV_ADMIN_URL; ?>/member.php?code=list">
                        신규 회원가입
                    </a>
                </dt>
                <dd class="box_contents">
                    <ul class="box_white board_list">
                        <?php
                            $sql = "select * from shop_member where id <> 'admin' order by index_no desc limit 4";
                            $result = sql_query($sql);
                            for($i=0; $row=sql_fetch_array($result); $i++){
                        ?>
                        <li>
                            <a href="#" class="board_title"><?php echo $row['name']; ?></a>
                            <span class="board_date"><?php echo substr($row['reg_time'],0,16); ?></span>
                        </li>
                        <?php
                            }
                            if($i==0)
                                echo '<li>자료가 없습니다.</li>';
                        ?>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt class="box_title link_type">
                    <a href="#">
                        상품 문의
                    </a>
                </dt>
                <dd class="box_contents">
                    <ul class="box_white board_list">
                        <li>
                            <a href="#" class="board_title">제품 정보가 궁급합니다.</a>
                            <span class="board_date">2024-06-23</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">대량 주문도 가능한가요?</a>
                            <span class="board_date">2024-06-22</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">배송이 언제 될까요?</a>
                            <span class="board_date">2024-06-22</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">제품 교환 요청</a>
                            <span class="board_date">2024-06-21</span>
                        </li>
                    </ul>
                </dd>
            </dl>
        </div>
    </div>
</div>

<!-- 
    그래프 스크립트
    https://apexcharts.com/ 스크립트 주소
 -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>


    // 임시 데이터
    // 건수
    const month_check = [[2478,24,35],[1528,58,18],[3438,21,25],[2468,34,38],[2428,20,31],[3580,24,45]]
    const month_money = [[113562000,656000,560900],[123542100,606000,526000],[112262000,656000,612500],[115272000,752000,628000],[113422000,20,31],[121712000,575000,845000]]

    const order_sel = document.querySelector('#order_month');
    const order_month1 = document.querySelector('#order_data_check1');
    const order_month2 = document.querySelector('#order_data_check2');
    const order_month3 = document.querySelector('#order_data_check3');
    const order_month4 = document.querySelector('#order_data_check4');
    const order_money1 = document.querySelector('#order_data_money1');
    const order_money2 = document.querySelector('#order_data_money2');
    const order_money3 = document.querySelector('#order_data_money3');
    const order_money4 = document.querySelector('#order_data_money4');

    console.log(order_month1)
    order_sel.addEventListener('change', function(){
        let change_value = order_sel.value;
        console.log(parseInt(month_check[change_value][0]), parseInt(month_check[change_value][1]), parseInt(month_check[change_value][2]));
        order_month1.innerText = month_check[change_value][0].toLocaleString()
        order_month2.innerText = month_check[change_value][1].toLocaleString()
        order_month3.innerText = month_check[change_value][2].toLocaleString()
        order_month4.innerText = (month_check[change_value][0] + month_check[change_value][1] + month_check[change_value][2]).toLocaleString()
    });


    // 막대 데이터
    const order_money = [15025000, 32502000, 22320300, 11029302, 25921090,4039320, 9092910];

    // 라인 데이터
    const sell_count = [237, 422, 354, 272, 432, 222, 175];

    // 그래프 라벨
    const graph_cate = ['2024-06-01', '2024-06-02', '2024-06-03', '2024-06-04', '2024-06-05', '2024-06-06', '2024-06-07'];

    const options = {
          series: [{
          name: '주문 금액',
          type: 'column',
          data: order_money, //['5000000', '25000000', '33000000', '40000000', '15000000', '20000000', '28000000']
        }, {
          name: '주문 건수',
          type: 'line',
          data: sell_count
        }],
            chart: {
                // 확대 축소 버튼 툴팁
                toolbar:false,
                height: 350,
                type: 'line',
        },
        // 색상
        colors: ["#FA6918", "#038A19"],
        // 그래프 카테고리
        legend:{
            position: 'top',
            horizontalAlign: 'right',
            markers: {
                radius: 0,
            },
            fontSize: '16px',
            fontFamily: "Noto Sans KR",
            // 카테고리 여백
            itemMargin: {
                horizontal: 20,
                vertical: 0
            },
        },
        // 그래프 배경
        grid: {
            row: {
                colors: ['#ffffff'],
                opacity: 0.5
            },
            padding: {
                left: 10,
                right: 10,
            }
        },
        // 선 그래프 굵기
        stroke: {
          width: [0, 2]
        },
        // 선 그래프 마커 크기
        markers:{
            size:5
        },
        // x 좌표 라벨
        xaxis: {
            categories:graph_cate,
            labels: {
                style: {
                    fontSize: '14px',
                    fontFamily: 'Noto Sans KR',
                },
            },
        },
        // y 좌표 라벨링
        yaxis: [{
            labels: {
                style: {
                    fontSize: '16px',
                    fontFamily: 'Noto Sans KR',
                },
                // 출력 포맷 방식
                formatter: function(val, index, dataPointIndex, seriesIndex) {
                    return val.toLocaleString();
                }
            }
        }, {
            // 그래프 오른쪽 Y좌표 데이터 표시
            opposite: true,
            labels: {
                style: {
                    fontSize: '16px',
                    fontFamily: 'Noto Sans KR',
                },
            },
        }],
        tooltip: {
            y: [{
                // 막대그래프 툴팁
                formatter: function (val) {
                    // 숫자 쉼표 작업
                    return  ' : &nbsp;' + val.toLocaleString();
                }
            }, {
                // 라인 그래프 툴팁
                formatter: function (val) {
                    return ' : &nbsp;' + val;
                }
            }]
        }
    };

        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>

<?php
include_once(BV_ADMIN_PATH."/admin_tail.php");
?>