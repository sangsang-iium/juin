<?php // 대시보드 작업 _20240703_SY
define('NO_CONTAINER', true);
include_once("./_common.php");
include_once(BV_ADMIN_PATH."/admin_access.php");
include_once(BV_ADMIN_PATH."/admin_head.php");
include_once(BV_ADMIN_PATH."/admin_topmenu.php");


// Month _20240703_SY
$currentYear = date("Y");
$currentMonth = date("n");
for ($month = 1; $month <= $currentMonth; $month++) {
    $monthData[] = sprintf("%d-%02d", $currentYear, $month);
    $monthText[] = $currentYear . '-' . $month;
}

// 당월 OrderDate 조회 _20240703_SY
$od_and_month = " AND od_time BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND LAST_DAY(NOW()) ";
// 금일 OrderDate 조회 _20240703_SY
$od_and_day   = " AND od_time LIKE DATE_FORMAT(NOW() ,'%Y-%m-%d') ";
// 일반 배송 _20240703_SY
$od_basic     = " AND od_id REGEXP '^[0-9]+$'";
// 정규 배송 _20240703_SY
$od_monthly   = " AND od_id REGEXP '^[0-9]+(_0)'";
// 일반+정규 
$od_all       = " AND od_id REGEXP '^[0-9]+(_0)?$'";


$sodrr    = admin_order_status_sum("WHERE dan > 0 {$od_and_month} {$od_all} "); // 총 주문내역
$sodrr_1  = admin_order_status_sum("WHERE dan > 0 {$od_and_day} {$od_all} ");   // 금일 총 주문내역
$sodr1    = admin_order_status_sum("WHERE dan = 1 {$od_and_month} "); // 총 입금대기
$sodr1_1  = admin_order_status_sum("WHERE dan = 1 {$od_and_month} {$od_basic} ");   // 당월 일반 입금대기
$sodr1_2  = admin_order_status_sum("WHERE dan = 1 {$od_and_month} {$od_monthly} "); // 당월 정기 입금대기
$sodr2    = admin_order_status_sum("WHERE dan = 2 {$od_and_month} {$od_all} "); // 총 입금완료
$sodr3    = admin_order_status_sum("WHERE dan = 3 {$od_and_month} "); // 총 배송준비
$sodr4    = admin_order_status_sum("WHERE dan = 4 {$od_and_month} "); // 총 배송중
$sodr5    = admin_order_status_sum("WHERE dan = 5 {$od_and_month} "); // 총 배송완료
$sodr6    = admin_order_status_sum("WHERE dan = 6 {$od_and_month} "); // 총 입금전 취소
$sodr6_1  = admin_order_status_sum("WHERE dan = 6 {$od_and_day} ");   // 금일 입금전 취소
$sodr7    = admin_order_status_sum("WHERE dan = 7 {$od_and_month} "); // 총 배송후 반품
$sodr8    = admin_order_status_sum("WHERE dan = 8 {$od_and_month} "); // 총 배송후 교환
$sodr9    = admin_order_status_sum("WHERE dan = 9 {$od_and_month} "); // 총 배송전 환불
$final    = admin_order_status_sum("WHERE dan = 5 AND user_ok = 0 {$od_and_month} "); // 총 구매미확정

/* ------------------------------------------------------------------------------------- _20240714_SY 
  * 미연동 데이터에 대한 "준비중" 문구 처리
  * 게시판 연동 작업
/* ------------------------------------------------------------------------------------- */
?>


<div id="main_dashboard">
    <div class="dashboard_boxs">
        <dl>
            <dt class="box_title select_type">
                금일 주문현황
                <div class="chk_select">
                    <select name="" id="order_month">
                      <?php foreach($monthText as $key => $val) { 
                        echo "<option value='{$key}'".($currentMonth == substr($val, 5) ? 'selected' : '') ." >".substr($val, 5)."월</option>";
                      } ?>
                    </select>
                </div>
            </dt>
            <dd class="box_contents">
                <div class="box_white">
                    <p class="content_title">주문</p>
                    <div class="cnt_data_box">
                        <p class="total_boxs">
                            <?php echo number_format($sodrr_1['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                        <p class="data_bot">
                            <?php echo number_format($sodrr_1['price']); ?>
                            <span class="cnt_unit_text">원</span>
                        </p>
                    </div>
                </div>       
                <div class="box_white">
                    <p class="content_title color_type1">취소</p>
                    <div class="cnt_data_box">
                        <p class="total_boxs color_type1">
                            <?php echo number_format($sodr6_1['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                        <p class="data_bot">
                            <?php echo number_format($sodr6_1['price']); ?>
                            <span class="cnt_unit_text">원</span>
                        </p>
                    </div>
                </div>       
            </dd>
        </dl>
        <dl class="w-300">
            <dt class="box_title">
                매출현황
            </dt>
            <dd class="box_contents line_box">
                <div class="order_line_cnt box_white">
                    <p class="content_title">결제완료</p>
                    <div class="approval_box">
                        <p class="order_line_num">
                            <span id="order_data_check1"><?php echo number_format($sodr2['cnt']); ?></span>
                            <span class="cnt_unit_text">건</span>
                        </p>
                        <p class="order_line_money">
                            <span id="order_data_money1"><?php echo number_format($sodr2['price']); ?></span>
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
                                    <span id="order_data_check2"><?php echo number_format($sodr1_1['cnt']); ?></span>
                                    <span class="cnt_unit_text">건</span>
                                </p>
                                <p class="order_line_money">
                                    <span id="order_data_money2"><?php echo number_format($sodr1_1['price']); ?></span>
                                    <span class="cnt_unit_text">원</span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <p class="regular_order">정기</p>
                            <div class="approval_box">
                                <p class="order_line_num color_type3">
                                <span id="order_data_check3"><?php echo number_format($sodr1_2['cnt']); ?></span>
                                    <span class="cnt_unit_text">건</span>
                                </p>
                                <p class="order_line_money">
                                    <span id="order_data_money3"><?php echo number_format($sodr1_2['price']); ?></span>
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
                            <span id="order_data_check4"><?php echo number_format($sodr2['cnt']); ?></span>
                            <span>건</span>
                        </p>
                        <p class="order_line_money">
                            <span id="order_data_money4"><?php echo number_format($sodr2['price']); ?></span>
                            <span class="cnt_unit_text">원</span>
                        </p>
                    </div>
                </div>
            </dd>
        </dl>
        <dl class="flex_fixed">
            <dt class="box_title link_type">
                <a href="#">회원통계</a>
            </dt>
            <dd class="box_contents">
                <div class="box_white">
                    <div class="mem-statics-wrap">
                        <div class="col2 mem-statics-col">
                            <div class="box-wrap">
                                <div class="box">
                                    <p class="t1 c1">가입회원</p>
                                    <p class="t2">
                                        <span class="num c1">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                            </div>
                            <div class="i-col-2 box-wrap">
                                <div class="box">
                                    <p class="t1 c2">설치</p>
                                    <p class="t2">
                                        <span class="num c2">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                                <div class="box">
                                    <p class="t1 c3">미설치</p>
                                    <p class="t2">
                                        <span class="num c3">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mem-statics-col">
                            <div class="row6 box-wrap">
                                <div class="box">
                                    <p class="t1 cb">일반 회원</p>
                                    <p class="t2">
                                        <span class="num">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                                <div class="box">
                                    <p class="t1 cb">중앙회 회원</p>
                                    <p class="t2">
                                        <span class="num">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                                <div class="box">
                                    <p class="t1 cb">임직원 회원</p>
                                    <p class="t2">
                                        <span class="num">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                                <div class="box">
                                    <p class="t1 cb">휴업 회원</p>
                                    <p class="t2">
                                        <span class="num">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                                <div class="box">
                                    <p class="t1 cb">폐업 회원</p>
                                    <p class="t2">
                                        <span class="num">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                                <div class="box">
                                    <p class="t1 cb">탈퇴 회원</p>
                                    <p class="t2">
                                        <span class="num">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col2 mem-statics-col">
                            <div class="box-wrap">
                                <div class="box">
                                    <p class="t1 c1">WEB</p>
                                    <p class="t2">
                                        <span class="num c1">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                            </div>
                            <div class="box-wrap">
                                <div class="box">
                                    <p class="t1 c2">APP</p>
                                    <p class="t2">
                                        <span class="num c2">00</span>
                                        <span class="unit">명</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </dd>
        </dl>
    </div>
    <div class="dashboard_boxs">
    <dl class="flex_fixed">
            <dt class="box_title link_type">
                <a href="#">매출순위(당월)</a>
            </dt>
            <dd class="box_contents rank_type">
                <div class="box_white">
                    <p class="content_title color_type2 none_bd">직할지회</p>
                    <!-- <ol>
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
                    </ol> -->
                    <ol>준비중입니다.</ol>
                </div>       
                <div class="box_white">
                    <p class="content_title color_type3 none_bd">시도지회</p>
                    <!-- <ol>
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
                    </ol> -->
                    <ol>준비중입니다.</ol>
                </div>       
            </dd>
        </dl>
        <div class="dashboard_graph">
            <dl>
                <dt class="box_title">주문실적현황(당월)</dt>
                <dd class="box_contents">
                    <div class="chart_box box_white">
                      <?php if($_SERVER['REMOTE_ADDR'] == '106.247.231.170') { ?>
                        <div id="chart" style="width:100%;"></div>
                      <?php } else { ?>
                        <div class="">준비중입니다.</div>
                      <?php } ?>
                    </div>
                </dd>
            </dl>
        </div>
    </div>
    <div class="dashboard_boxs">
        <!-- <div class="recent-regi-box">
            <dt class="box_title link_type">
                <a href="/admin/goods.php?code=list">최근 등록된 상품</a>
            </dt>
            <dd class="box_contents rank_type new_item_list">
                <ol class="box_white">
                <?php 
                  $goods_data = getNewGoodsFunc();
                  if(is_array($goods_data)) {
                    foreach($goods_data as $entry) { ?>
                      <li>
                          <a href="/admin/goods.php?code=form&w=u&gs_id=<?php echo $entry['index_no']?>" class="board_title"><?php echo maskingText($entry['gname'], 30)?></a>
                      </li>
                <?php }} else {
                  echo "<li>자료가 없습니다.</li>";
                } ?>
                </ol>
            </dd>
        </div> -->
        <div class="dashboard_boards">
            <dl class="w-30per">
                <dt class="box_title link_type">
                    <a href="/m/bbs/board_list.php?boardid=13">
                        공지사항
                    </a>    
                </dt>
                <dd class="box_contents">
                    <ul class="box_white board_list">
                      <?php 
                        $notice_data = getIndexDataFunc("shop_board_13");
                        if(is_array($notice_data)) {
                          foreach($notice_data as $entry) { ?>
                            <li>
                                <a href="/m/bbs/board_read.php?index_no=<?php echo $entry['index_no']?>" class="board_title"><?php echo $entry['subject']?></a>
                                <span class="board_date"><?php echo date("Y-m-d", $entry['wdate']); ?></span>
                            </li>
                      <?php }} else {
                        echo "<li>자료가 없습니다.</li>";
                      } ?>
                    </ul>
                </dd>
            </dl>
            <dl class="w-30per">
                <dt class="box_title link_type">
                    <a href="/admin/help.php?code=qa">
                        1대1 문의
                    </a>
                </dt>
                <dd class="box_contents">
                    <ul class="box_white board_list">
                      <?php 
                        $qa_data = getIndexDataFunc("shop_qa");
                        if(is_array($qa_data)) {
                          foreach($qa_data as $entry) { ?>
                            <li>
                                <a href="/admin/help.php?code=qa_form&w=u&index_no=<?php echo $entry['index_no']?>" class="board_title"><?php echo $entry['subject']?></a>
                                <span class="board_date"><?php echo substr($entry['wdate'], 0, 10); ?></span>
                            </li>
                      <?php }} else {
                        echo "<li>자료가 없습니다.</li>";
                      } ?>
                    </ul>
                </dd>
            </dl>
            <dl class="w-30per">
                <dt class="box_title">
                    <a href="/admin">
                        상품 문의
                    </a>
                </dt>
                <dd class="box_contents">
                    <ul class="box_white board_list">
                      <?php 
                        $iq_data = getIndexDataFunc("shop_goods_qa", "iq_time");
                        if(is_array($iq_data)) {
                          foreach($iq_data as $entry) { 
                        // 공급사 계정 조회 _20240724_ SY
                        $sellerInfo_sel = " SELECT * FROM shop_seller AS ss
                                         LEFT JOIN shop_member AS mm
                                                ON (ss.index_no = mm.id) 
                                             WHERE seller_code = '{$entry['seller_id']}' ";
                        $sellerInfo_row = sql_fetch($sellerInfo_sel);
                      ?>
                            <li>
                              <a href="/admin/admin_ss_login.php?mb_id=<?php echo $sellerInfo_row['mb_id']."&amp;lg_type=S"; ?>" class="board_title" target="_blank"><?php echo $entry['iq_subject']?></a>
                              <span class="board_date"><?php echo substr($entry['iq_time'], 0, 10); ?></span>
                            </li>
                      <?php }} else {
                        echo "<li>자료가 없습니다.</li>";
                      } ?>
                    </ul>
                </dd>
            </dl>
            <dl>
                <dt class="box_title link_type">
                    <a href="/admin/goods.php?code=list">최근 등록된 상품</a>
                </dt>
                <dd class="box_contents rank_type new_item_list">
                    <ol class="box_white">
                    <?php 
                    $goods_data = getNewGoodsFunc();
                    if(is_array($goods_data)) {
                        foreach($goods_data as $entry) { ?>
                        <li>
                            <a href="/admin/goods.php?code=form&w=u&gs_id=<?php echo $entry['index_no']?>" class="board_title"><?php echo maskingText($entry['gname'], 30)?></a>
                        </li>
                    <?php }} else {
                    echo "<li>자료가 없습니다.</li>";
                    } ?>
                    </ol>
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
                          $sql = "select * from shop_member where id <> 'admin' AND id <> 'iium' order by index_no desc limit 5";
                          $result = sql_query($sql);
                          for($i=0; $row=sql_fetch_array($result); $i++){
                      ?>
                      <li>
                          <a href="<?php echo BV_ADMIN_URL; ?>/member.php?code=list" class="board_title"><?php echo $row['name']; ?></a>
                          <span class="board_date"><?php echo substr($row['reg_time'],0,16); ?></span>
                      </li>
                      <?php
                          }
                          if($i==0)
                            echo "<li>자료가 없습니다.</li>";
                      ?>
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
    const month_check = [[2478,24,35],[1528,58,18],[3438,21,25],[2468,34,38],[2428,20,31],[3580,24,45], [3580,24,45]]
    const month_money = [[113562000,656000,560900],[123542100,606000,526000],[112262000,656000,612500],[115272000,752000,628000],[113422000,20,31],[121712000,575000,845000], [121712000,575000,845000]]

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