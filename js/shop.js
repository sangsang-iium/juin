var option_add = false;
var supply_add = false;
var isAndroid = (navigator.userAgent.toLowerCase().indexOf("android") > -1);

$(function() {
    // 선택옵션
    /* 가상커서 ctrl keyup 이베트 대응 */
    /*
    $(document).on("keyup", "select.it_option", function(e) {
        var sel_count = $("select.it_option").size();
        var idx = $("select.it_option").index($(this));
        var code = e.keyCode;
        var val = $(this).val();

        option_add = false;
        if(code == 17 && sel_count == idx + 1) {
            if(val == "")
                return;

            sel_option_process(true);
        }
    });
    */

    // isEmpty _20240806_SY
    const isEmpty = (input) => {
      if(
        typeof input === "undefined" ||
        input === null ||
        input === "" ||
        input === "null" ||
        input.length === 0 ||
        (typeof input === "object" && !Object.keys(input).length)
      )
      {
        return true;
      } 
      else return false; 
    }

    /* 키보드 접근 후 옵션 선택 Enter keydown 이벤트 대응 */
    $(document).on("keydown", "select.it_option", function(e) {
        var sel_count = $("select.it_option").size();
        var idx = $("select.it_option").index($(this));
        var code = e.keyCode;
        var val = $(this).val();

        option_add = false;
        if(code == 13 && sel_count == idx + 1) {
            if(val == "")
                return;

            sel_option_process(true);
        }
    });

    if(isAndroid) {
        $(document).on("touchend", "select.it_option", function() {
            option_add = true;
        });
    } else {
        $(document).on("mouseup", "select.it_option", function() {
            option_add = true;
        });
    }

    $(document).on("change", "select.it_option", function() {
        var sel_count = $("select.it_option").size();
        var idx = $("select.it_option").index($(this));
        var val = $(this).val();
        var gs_id = $("input[name='gs_id[]']").val();

        // 선택값이 없을 경우 하위 옵션은 disabled
        if(val == "") {
            $("select.it_option:gt("+idx+")").val("").attr("disabled", true);
            return;
        }

        // 하위주문옵션로드
        if(sel_count > 1 && (idx + 1) < sel_count) {
            var opt_id = "";

            // 상위 옵션의 값을 읽어 옵션id 만듬
            if(idx > 0) {
                $("select.it_option:lt("+idx+")").each(function() {
                    if(!opt_id)
                        opt_id = $(this).val();
                    else
                        opt_id += chr(30)+$(this).val();
                });

                opt_id += chr(30)+val;
            } else if(idx == 0) {
                opt_id = val;
            }

            $.post(
                "/shop/view_option.php",
                { gs_id: gs_id, opt_id: opt_id, idx: idx, sel_count: sel_count },
                function(data) {
                    $("select.it_option").eq(idx+1).empty().html(data).attr("disabled", false);

                    // select의 옵션이 변경됐을 경우 하위 옵션 disabled
                    if(idx+1 < sel_count) {
                        var idx2 = idx + 1;
                        $("select.it_option:gt("+idx2+")").val("").attr("disabled", true);
                    }
                }
            );

        } else if((idx + 1) == sel_count) { // 주문옵션처리
            if(option_add && val == "")
                return;

            var info = val.split(",");
            // 재고체크
            if(parseInt(info[2]) < 1) {
                alert("선택하신 주문옵션상품은 재고가 부족하여 구매할 수 없습니다.");
                return false;
            }

            if(option_add)
                sel_option_process(true);
        }
    });

    // 추가옵션
    /* 가상커서 ctrl keyup 이베트 대응 */
    /*
    $(document).on("keyup", "select.it_supply", function(e) {
        var $el = $(this);
        var code = e.keyCode;
        var val = $(this).val();

        supply_add = false;
        if(code == 17) {
            if(val == "")
                return;

            sel_supply_process($el, true);
        }
    });
    */

    /* 키보드 접근 후 옵션 선택 Enter keydown 이벤트 대응 */
    $(document).on("keydown", "select.it_supply", function(e) {
        var $el = $(this);
        var code = e.keyCode;
        var val = $(this).val();

        supply_add = false;
        if(code == 13) {
            if(val == "")
                return;

            sel_supply_process($el, true);
        }
    });

    if(isAndroid) {
        $(document).on("touchend", "select.it_supply", function() {
            supply_add = true;
        });
    } else {
        $(document).on("mouseup", "select.it_supply", function() {
            supply_add = true;
        });
    }

    $(document).on("change", "select.it_supply", function() {
        var $el = $(this);
        var val = $(this).val();

        if(val == "")
            return;

        if(supply_add)
            sel_supply_process($el, true);
    });

    // 수량변경 및 삭제
	$(document).on("click", "#option_set_list li button", function() {
        var mode = $(this).text();
        // var this_qty, max_qty = 9999, min_qty = 1;
        var $el_qty = $(this).closest("li").find("input[name^=ct_qty]");
        var stock = parseInt($(this).closest("li").find("input.io_stock").val());

        // 최대/최소 주문 수량 _20240806_SY
        var minQty = $(this).closest("li").find("input.io_minqty").val();
        var maxQty = $(this).closest("li").find("input.io_maxqty").val();
        if(isEmpty(minQty)) {
          minQty = 1;
        } else {
          minQty = parseInt(minQty)
        }
        
        if(isEmpty(maxQty)) {
          maxQty = 999999999;
        } else {
          maxQty = parseInt(maxQty)
        }
        console.log(minQty, maxQty)
        var this_qty, max_qty = maxQty, min_qty = minQty;

		switch(mode) {
            case "증가":
                this_qty = parseInt($el_qty.val().replace(/[^0-9]/, "")) + minQty;
                if(this_qty > stock) {
                    alert("재고수량 보다 많은 수량을 구매할 수 없습니다.");
                    this_qty = stock;
                }

                if(this_qty > max_qty) {
                    this_qty = max_qty;
                    alert("최대 구매수량은 "+number_format(String(max_qty))+" 이하 입니다.");
                }

                $el_qty.val(this_qty);
                price_calculate();
                break;

            case "감소":
                this_qty = parseInt($el_qty.val().replace(/[^0-9]/, "")) - minQty;
                if(this_qty < min_qty) {
                    this_qty = min_qty;
                    alert("최소 구매수량은 "+number_format(String(min_qty))+" 이상 입니다.");
                }
                $el_qty.val(this_qty);
                price_calculate();
                break;

            case "삭제":
                if(confirm("선택하신 옵션항목을 삭제하시겠습니까?")) {
                    var $el = $(this).closest("li");
                    var del_exec = true;

                    if($("#option_set_list .sit_opt_list").size() > 0) {
                        // 주문옵션이 하나이상인지
                        if($el.hasClass("sit_opt_list")) {
                            if($(".sit_opt_list").size() <= 1)
                                del_exec = false;
                        }
                    }

                    if(del_exec) {
                        $el.closest("li").remove();
                        price_calculate();
                    } else {
                        alert("주문옵션은 하나이상이어야 합니다.");
                        return false;
                    }
                }
                break;

            default:
                alert("올바른 방법으로 이용해 주십시오.");
                break;
        }
    });

	// 수량직접입력
	$(document).on("keyup", "input[name^=ct_qty]", function() {
        var val= $(this).val();

        if(val != "") {
            if(val.replace(/[0-9]/g, "").length > 0) {
                alert("수량은 숫자만 입력해 주십시오.");
                $(this).val(1);
            } else {
                var d_val = parseInt(val);
                if(d_val < 1 || d_val > 9999) {
                    alert("수량은 1에서 9999 사이의 값으로 입력해 주십시오.");
                    $(this).val(1);
                } else {
                    var stock = parseInt($(this).closest("li").find("input.io_stock").val());
                    if(d_val > stock) {
                        alert("재고수량 보다 많은 수량을 구매할 수 없습니다.");
                        $(this).val(stock);
                    }
                }
            }

            price_calculate();
        }
    });
});

// 주문옵션 추가처리
function sel_option_process(add_exec)
{
    var id = "";
    var value, info, sel_opt, item, price, stock, amt, run_error = false;
    var option = sep = "";
    info = $("select.it_option:last").val().split(",");

    $("select.it_option").each(function(index) {
        value = $(this).val();
        item = $(this).closest(".vi_txt_li dl").find("dt label").text();
        
        if(!value) {
            run_error = true;
            return false;
        }

        // 옵션선택정보
        sel_opt = value.split(",")[0];

        if(id == "") {
            id = sel_opt;
        } else {
            id += chr(30)+sel_opt;
            sep = " / ";
        }

        option += sep + item + ":" + sel_opt;
    });

    if(run_error) {
        alert(item+"을(를) 선택해 주십시오.");
        return false;
    }

    price = info[1];
    stock = info[2];
    amt = info[3];
    console.log(info)
    if(add_exec) {
        if(same_option_check(option))
            return;

        add_sel_option(0, id, option, price, stock, amt);
    }
}

// 추가옵션 추가처리
function sel_supply_process($el, add_exec)
{
    var val = $el.val();
    var item = $el.closest(".vi_txt_li dl").find("dt label").text();

    if(!val) {
        alert(item+"을(를) 선택해 주십시오.");
        return;
    }

    var info = val.split(",");

    // 재고체크
    if(parseInt(info[2]) < 1) {
        alert(info[0]+"은(는) 재고가 부족하여 구매할 수 없습니다.");
        return false;
    }

    var id = item+chr(30)+info[0];
    var option = item+":"+info[0];
    var price = info[1];
    var stock = info[2];
	var amt = info[3];

    if(add_exec) {
        if(same_option_check(option))
            return;

        add_sel_option(1, id, option, price, stock, amt);
    }
}

// 선택된 옵션 출력
function add_sel_option(type, id, option, price, stock, amt)
{
    var item_code = $("input[name='gs_id[]']").val();
    var opt = "";
    var li_class = "sit_opt_list";
    if(type)
        li_class = "sit_spl_list";

    var opt_prc;
	var pamt = parseInt(price) + parseInt(amt);
    if(parseInt(pamt) >= 0)
        opt_prc = "+"+number_format(String(pamt))+"원";
    else
        opt_prc = number_format(String(pamt))+"원";

    opt += "<li class=\""+li_class+" vi_txt_li\">\n";
	opt += "<dl>\n";
    opt += "<input type=\"hidden\" name=\"io_type["+item_code+"][]\" value=\""+type+"\">\n";
    opt += "<input type=\"hidden\" name=\"io_id["+item_code+"][]\" value=\""+id+"\">\n";
    opt += "<input type=\"hidden\" name=\"io_value["+item_code+"][]\" value=\""+option+"\">\n";
    opt += "<input type=\"hidden\" class=\"io_price\" value=\""+price+"\">\n";
    opt += "<input type=\"hidden\" class=\"io_stock\" value=\""+stock+"\">\n";
		opt += "<dt class=\"op_vi_tit\"><span class=\"sit_opt_subj\">"+option+"</span></dt>\n";
		opt += "<dd class=\"op_vi_txt\">\n";
			opt += "<button type=\"button\" class=\"defbtn_minus\">감소</button>";
			opt += "<input type=\"text\" name=\"ct_qty["+item_code+"][]\" value=\"1\" class=\"inp_opt\" size=\"2\">";
			opt += "<button type=\"button\" class=\"defbtn_plus\">증가</button>";
			opt += "<span class=\"sit_opt_prc\">"+opt_prc+"</span>\n";
			opt += "<button type=\"button\" class=\"defbtn_delete\">삭제</button>\n";
		opt += "</dd>\n";
	opt += "</dl>\n";
    opt += "</li>\n";

    if($("#option_set_list > ul").size() < 1) {
        $("#option_set_list").html("<ul id=\"option_set_added\"></ul>");
        $("#option_set_list > ul").html(opt);
    } else{
        if(type) {
            if($("#option_set_list .sit_spl_list").size() > 0) {
                $("#option_set_list .sit_spl_list:last").after(opt);
            } else {
                if($("#option_set_list .sit_opt_list").size() > 0) {
                    $("#option_set_list .sit_opt_list:last").after(opt);
                } else {
                    $("#option_set_list > ul").html(opt);
                }
            }
        } else {
            if($("#option_set_list .sit_opt_list").size() > 0) {
                $("#option_set_list .sit_opt_list:last").after(opt);
            } else {
                if($("#option_set_list .sit_spl_list").size() > 0) {
                    $("#option_set_list .sit_spl_list:first").before(opt);
                } else {
                    $("#option_set_list > ul").html(opt);
                }
            }
        }
    }

    price_calculate();
}

// 동일주문옵션있는지
function same_option_check(val)
{
    var result = false;
    $("input[name^=io_value]").each(function() {
        if(val == $(this).val()) {
            result = true;
            return false;
        }
    });

    if(result)
        alert(val+" 은(는) 이미 추가하신 옵션상품입니다.");

    return result;
}

// 가격계산
function price_calculate()
{
    var it_price = parseInt($("input#it_price").val());

    if(isNaN(it_price))
        return;

    var $el_prc = $("input.io_price");
    var $el_qty = $("input[name^=ct_qty]");
    var $el_type = $("input[name^=io_type]");
    var price, type, qty, total = 0;

    $el_prc.each(function(index) {
        price = parseInt($(this).val());
        qty = parseInt($el_qty.eq(index).val());
        type = $el_type.eq(index).val();

        if(type == "0") { // 주문옵션
            total += (it_price + price) * qty;
        } else { // 추가옵션
            total += price * qty;
        }
    });

	$("#sit_tot_views").show();
    $("#sit_tot_price").empty().html(number_format(String(total))+"<em>원</em>");
}

// php chr() 대응
function chr(code)
{
    return String.fromCharCode(code);
}
