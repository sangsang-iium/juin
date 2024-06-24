<?php
if(!defined('_BLUEVATION_')) exit;

$pg_title = "전체 거래진행 통계내역";
include_once("./admin_head.sub.php");

$sql_where = " where seller_id = '{$seller['seller_code']}' ";

$sodrr = admin_order_status_sum("{$sql_where} and dan > 1 "); // 총 주문내역
$sodr2 = admin_order_status_sum("{$sql_where} and dan = 2 "); // 총 입금완료
$sodr3 = admin_order_status_sum("{$sql_where} and dan = 3 "); // 총 배송준비
$sodr4 = admin_order_status_sum("{$sql_where} and dan = 4 "); // 총 배송중
$sodr5 = admin_order_status_sum("{$sql_where} and dan = 5 "); // 총 배송완료
$sodr6 = admin_order_status_sum("{$sql_where} and dan = 6 "); // 총 입금전 취소
$sodr7 = admin_order_status_sum("{$sql_where} and dan = 7 "); // 총 배송후 반품
$sodr8 = admin_order_status_sum("{$sql_where} and dan = 8 "); // 총 배송후 교환
$sodr9 = admin_order_status_sum("{$sql_where} and dan = 9 "); // 총 배송전 환불
$final1 = admin_order_status_sum("{$sql_where} and dan = 5 and user_ok = 1 "); // 총 구매확정
$final2 = admin_order_status_sum("{$sql_where} and dan = 5 and user_ok = 0 "); // 총 구매미확정
?>

<link rel="stylesheet" href="<?php echo BV_ADMIN_URL; ?>/css/reset_md.css?ver=<?php echo BV_CSS_VER; ?>"> <!-- 리셋css_김민규 -->
<link rel="stylesheet" href="<?php echo BV_ADMIN_URL; ?>/css/style_md.css?ver=<?php echo BV_CSS_VER; ?>"> <!-- 스타일css_김민규 -->

<div id="main_dashboard" class="bg_white">
	<div class="dashboard_boxs">
		<dl>
			<dt class="box_title">전체 주문통계</dt>
			<dd class="box_contents">
				<div class="box_white">
					<p class="content_title">총 주문건수</p>
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
			</dd>
		</dl>
		<dl>
            <dt class="box_title">주문상태 현황</dt>
            <dd class="box_contents box_type">
                <div class="order_line_cnt box_white">
                    <p class="content_title">입금완료</p>
                    <div class="approval_box">
                        <p class="order_line_num">
							<?php echo number_format($sodr2['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
                </div>
                <div class="order_line_cnt box_white">
                    <p class="content_title color_type4">배송준비</p>
					<div class="approval_box">
                        <p class="order_line_num color_type4">
							<?php echo number_format($sodr3['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
                </div>
                <div class="order_line_cnt box_white">
                    <p class="content_title color_type2">배송중</p>
                    <div class="approval_box">
                        <p class="order_line_num color_type2">
							<?php echo number_format($sodr4['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
                </div>
                <div class="order_line_cnt box_white">
                    <p class="content_title color_type3">배송완료</p>
					<div class="approval_box">
                        <p class="order_line_num color_type3">
							<?php echo number_format($sodr5['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
                </div>
                <div class="order_line_cnt box_white full_size">
                    <p class="content_title color_type1">구매확정</p>
                    <div class="approval_box">
                        <p class="order_line_num color_type1">
							<?php echo number_format($final1['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
                </div>
            </dd>
        </dl>
		<dl>
            <dt class="box_title">구매확정/클래임 현황</dt>
            <dd class="box_contents box_type">
                <div class="order_line_cnt box_white">
                    <p class="content_title">구매미확정</p>
                    <div class="approval_box">
                        <p class="order_line_num">
							<?php echo number_format($final2['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
                </div>
                <div class="order_line_cnt box_white">
                    <p class="content_title color_type4">취소</p>
					<div class="approval_box">
                        <p class="order_line_num color_type4">
						<?php echo number_format($sodr6['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
                </div>
                <div class="order_line_cnt box_white">
                    <p class="content_title color_type2">환불</p>
                    <div class="approval_box">
                        <p class="order_line_num color_type2">
							<?php echo number_format($sodr9['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
                </div>
                <div class="order_line_cnt box_white">
                    <p class="content_title color_type3">반품</p>
					<div class="approval_box">
                        <p class="order_line_num color_type3">
							<?php echo number_format($sodr7['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
                </div>
                <div class="order_line_cnt box_white full_size">
                    <p class="content_title color_type1">교환</p>
                    <div class="approval_box">
                        <p class="order_line_num color_type1">
						<?php echo number_format($sodr8['cnt']); ?>
                            <span class="cnt_unit_text">건</span>
                        </p>
                    </div>
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
                <dt class="box_title">매출 현황, 정산 예정금액</dt>
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
					<a href="<?php echo BV_MYPAGE_URL; ?>/page.php?code=seller_odr_list">최근 주문내역</a>
				</dt>
				<dd class="box_contents">
					<ul class="box_white board_list">
					<?php
						$sql = " select * from shop_order {$sql_where} and dan > 1 group by od_id order by index_no desc limit 5 ";
						$res = sql_query($sql);
						for($i=0; $row=sql_fetch_array($res); $i++){
							$amount = get_order_spay($row['od_id'], " and seller_id = '{$seller['seller_code']}' ");
						?>
						<li>
							<a href="#" class="board_title"><?php echo $row['od_id']; ?></a>
							<span class="board_date"><?php echo substr($row['od_time'],0,10); ?></span>
						</li>
						<?php
							}
							if($i==0)
								echo '<li><p class="board_title">자료가 없습니다.</p></li>';
						?>
					</ul>          
				</dd>
			</dl>
			<dl>
				<dt class="box_title link_type">
					<a href="<?php echo BV_BBS_URL; ?>/list.php?boardid=21">상품 문의</a>
				</dt>
				<dd class="box_contents">
					<ul class="box_white board_list">
						<?php
						$sql = "select * from shop_board_21 order by wdate desc limit 5 ";
						$res = sql_query($sql);
						for($i=0;$row=sql_fetch_array($res);$i++){
							$bo_subject = cut_str($row['subject'],40);
							$bo_date = date('Y-m-d', $row['wdate']);
							$bo_href = BV_BBS_URL."/read.php?boardid=21&index_no=$row[index_no]";
						?>
						<li>
							<a href="<?php echo $bo_href; ?>" class="board_title">
							<?php echo $bo_subject; ?>
							</a>
							<span class="board_date"><?php echo $bo_date; ?></span>
						</li>
						<?php
							}
							if($i==0)
								echo '<li><p class="board_title">자료가 없습니다.</p></li>';
						?>
					</ul>          
				</dd>
			</dl>
			<dl class="box_odd">
				<dt class="box_title link_type">
					<a href="<?php echo BV_BBS_URL; ?>/list.php?boardid=20">공지사항</a>
				</dt>
				<dd class="box_contents">
					<ul class="box_white board_list">
						<?php
						$sql = "select * from shop_board_20 order by wdate desc limit 5 ";
						$res = sql_query($sql);
						for($i=0;$row=sql_fetch_array($res);$i++){
							$bo_subject = cut_str($row['subject'],40);
							$bo_date = date('Y-m-d', $row['wdate']);
							$bo_href = BV_BBS_URL."/read.php?boardid=20&index_no=$row[index_no]";
						?>
						<li>
							<a href="<?php echo $bo_href; ?>" class="board_title">
								<?php echo $bo_subject; ?>
							</a>
							<span class="board_date"><?php echo $bo_date; ?></span>
						</li>
						<?php
							}
							if($i==0)
								echo '<li><p class="board_title">게시글이 없습니다.</p></li>';
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

    // 막대 데이터
    const order_money = [5000000, 10000000, 22320300, 21029302, 2192109,4039320, 9092918];

    // 라인 데이터
    const sell_count = [23733124, 4221231, 3541231, 2722123, 4321232, 2221323, 1751123];

    // 그래프 라벨
    const graph_cate = ['2024-06-01', '2024-06-02', '2024-06-03', '2024-06-04', '2024-06-05', '2024-06-06', '2024-06-07'];

    const options = {
          series: [{
          name: '공급사 매출현황',
          type: 'column',
          data: order_money, //['5000000', '25000000', '33000000', '40000000', '15000000', '20000000', '28000000']
        }, {
          name: '정산 예정금액',
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
				// 출력 포맷 방식
                formatter: function(val, index, dataPointIndex, seriesIndex) {
                    return val.toLocaleString();
                }
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
                    return ' : &nbsp;' +val.toLocaleString();
                }
            }]
        }
    };

        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>

<?php
include_once("./admin_tail.sub.php");
?>