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
                            0
                            <span class="cnt_unit_text">원</span>
                        </p>
                    </div>
                </div>       
            </dd>
        </dl>
        <dl>
            <dt class="box_title">구매확정/클래임 현황</dt>
            <dd class="box_contents line_box">
                <div class="order_line_cnt box_white">
                    <p class="content_title">결제완료</p>
                    <div class="approval_box">
                        <p class="order_line_num">
                            2,222
                            <span class="cnt_unit_text">건</span>
                        </p>
                        <p class="order_line_money">
                            111,111,111
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
                                    2,222
                                    <span class="cnt_unit_text">건</span>
                                </p>
                                <p class="order_line_money">
                                    111,111,111
                                    <span class="cnt_unit_text">원</span>
                                </p>
                            </div>
                        </li>
                        <li>
                            <p class="regular_order">정기</p>
                            <div class="approval_box">
                                <p class="order_line_num color_type3">
                                    2,222
                                    <span class="cnt_unit_text">건</span>
                                </p>
                                <p class="order_line_money">
                                    111,111,111
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
                            2,222
                            <span>건</span>
                        </p>
                        <p class="order_line_money">
                            111,111,111
                            <span>원</span>
                        </p>
                    </div>
                </div>
            </dd>
        </dl>
        <dl>
            <dt class="box_title link_type">
                <a href="#">매출순위(당월)</a>
            </dt>
            <dd class="box_contents rank_type">
                <div class="box_white">
                    <p class="content_title color_type2 none_bd">직할지회</p>
                    <ol>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type2">1,000,000</p>
                        </li>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type2">1,000,000</p>
                        </li>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type2">1,000,000</p>
                        </li>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type2">1,000,000</p>
                        </li>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type2">1,000,000</p>
                        </li>
                    </ol>
                </div>       
                <div class="box_white">
                    <p class="content_title color_type3 none_bd">시도지회</p>
                    <ol>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type3">1,000,000</p>
                        </li>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type3">1,000,000</p>
                        </li>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type3">1,000,000</p>
                        </li>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type3">1,000,000</p>
                        </li>
                        <li>
                            <p class="rank_name">지회</p>
                            <p class="rank_money color_type3">1,000,000</p>
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
                        <a href="#" class="new_item_name">상품 이름</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">상품 이름</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">상품 이름</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">상품 이름</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">상품 이름</a>
                    </li>
                    <li>
                        <a href="#" class="new_item_name">상품 이름</a>
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
                            <a href="#" class="board_title">공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용공지사항 내용</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">공지사항 내용</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">공지사항 내용</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">공지사항 내용</a>
                            <span class="board_date">2024-06-01</span>
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
                            <a href="#" class="board_title">1대1 문의 내용</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">1대1 문의 내용</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">1대1 문의 내용</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">1대1 문의 내용</a>
                            <span class="board_date">2024-06-01</span>
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
                            <a href="#" class="board_title">상품 문의 내용</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">상품 문의 내용</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">상품 문의 내용</a>
                            <span class="board_date">2024-06-01</span>
                        </li>
                        <li>
                            <a href="#" class="board_title">상품 문의 내용</a>
                            <span class="board_date">2024-06-01</span>
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

    // 막대 데이터
    const order_money = [5000000, 10000000, 22320300, 21029302, 2192109,4039320, 9092918];

    // 라인 데이터
    const sell_count = [237, 422, 354, 2722, 432, 222, 175];

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