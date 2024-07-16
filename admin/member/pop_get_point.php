<?php
include_once "./_common.php";

$tb['title'] = '카테고리 제외 설정';
include_once BV_ADMIN_PATH . "/admin_head.php";

$sql      = "SELECT * FROM shop_member_grade WHERE gb_no = '{$gb_no}' ";
$row      = sql_fetch($sql);
?>
<style>
  .tag {
    display: inline-flex;
    align-items: center;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 5px 10px;
    margin: 10px;
    font-size: 14px;
    color: #333;
}

.tag-text {
    margin-right: 10px;
}

.tag-close {
    font-size: 16px;
    cursor: pointer;
    color: #999;
}

.tag-close:hover {
    color: #666;
}
</style>

<h1 class="newp_tit"><?php echo $tb['title']; ?></h1>
<div class="new_win_body">
  <form id="categoryForm" action="/admin/member/pop_get_point_update.php" method="POST">
    <input type="hidden" name="gb_no" value="<?php echo $gb_no ?>">
    <div class="guidebox tac">
      <ul class="tel_input ">
        <li class="chk_select">
            <?php echo get_category_select_1('sel_ca1', $sel_ca1); ?>
        </li>
        <li class="chk_select">
            <?php echo get_category_select_2('sel_ca2', $sel_ca2); ?>
        </li>
        <li class="chk_select">
            <?php echo get_category_select_3('sel_ca3', $sel_ca3); ?>
        </li>
        <li>
          <button type="button"  id="selectButton">선택</button>
        </li>
      </ul>
    </div>

    <script>
        $(function() {
          $("#sel_ca1").multi_select_box("#sel_ca",4,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
          $("#sel_ca2").multi_select_box("#sel_ca",4,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
          $("#sel_ca3").multi_select_box("#sel_ca",4,bv_admin_url+"/ajax.category_select_json.php","=카테고리선택=");
          $("#sel_ca4").multi_select_box("#sel_ca",4,"","=카테고리선택=");
        });
        </script>

    <div class="tbl_head01 " id="tagContainer">
      <?php
      if (isset($row['gb_category']) && !empty($row['gb_category']) ) {
        $cateArr = explode(",", $row['gb_category']);
        foreach ($cateArr as $cateItem) { ?>
          <div class="tag">
            <span class="tag-text"><?php echo $cateItem ?></span>
            <span class="tag-close" onclick="removeTag(this)">&#10006;</span>
          </div>
      <?php  }
       }
      ?>
    </div>
    <input type="hidden" name="selectedTags" id="selectedTags" value="<?php echo $row['gb_category'] ?>">
    <button type="submit" class="btn_acc">폼 전송</button>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
            var selectButton = document.getElementById('selectButton');
            var tagContainer = document.getElementById('tagContainer');
            var selectedTagsInput = document.getElementById('selectedTags');

            selectButton.addEventListener('click', function() {
                var selectedCategory1 = document.getElementById('sel_ca1').value;
                var selectedCategory2 = document.getElementById('sel_ca2').value;
                var selectedCategory3 = document.getElementById('sel_ca3').value;

                var lastSelectedCategory;

                if (selectedCategory3) {
                    lastSelectedCategory = selectedCategory3;
                } else if (selectedCategory2) {
                    lastSelectedCategory = selectedCategory2;
                } else if (selectedCategory1) {
                    lastSelectedCategory = selectedCategory1;
                } else {
                    alert('선택된 카테고리가 없습니다.');
                    return;
                }

                // 새로운 태그 생성
                var newTag = document.createElement('div');
                newTag.classList.add('tag');

                var tagText = document.createElement('span');
                tagText.classList.add('tag-text');
                tagText.textContent = lastSelectedCategory;

                var tagClose = document.createElement('span');
                tagClose.classList.add('tag-close');
                tagClose.innerHTML = '&#10006;';
                tagClose.onclick = function() {
                    removeTag(this);
                };

                newTag.appendChild(tagText);
                newTag.appendChild(tagClose);

                tagContainer.appendChild(newTag);
                updateHiddenInput();
            });

            window.removeTag = function(element) {
                var tag = element.parentElement;
                tag.remove(); // 완전히 삭제
                updateHiddenInput(); // 숨겨진 입력 필드 업데이트
            }

            function updateHiddenInput() {
                var tags = tagContainer.querySelectorAll('.tag-text');
                var tagValues = [];
                tags.forEach(function(tag) {
                    tagValues.push(tag.textContent);
                });
                selectedTagsInput.value = tagValues.join(',');
            }

            // 페이지 로드 시 초기 태그들에 대해 숨겨진 입력 필드 업데이트
            updateHiddenInput();
        });
  // name 추가_20240415_SY
function yes(data) {
  // 인코딩 추가 _20240621_SY
  if (typeof data === 'string') {
    data = JSON.parse(data);
  }
  opener.document.fregform.mb_id.value = data.seller_code;

  if (opener.document.fregform.name) {
      opener.document.fregform.name.value = data.company_name;
  }
  if (opener.document.fregform.in_type) {
      opener.document.fregform.in_type.value = data.income_type;
  }
  if (opener.document.fregform.in_per_type) {
      opener.document.fregform.in_per_type.value = data.income_per_type;
  }
  if (opener.document.fregform.in_price) {
      opener.document.fregform.in_price.value = data.income_price;
  }
  if (opener.document.fregform.in_per) {
      opener.document.fregform.in_per.value = data.income_per;
  }
  self.close();
}
</script>

<?php
include_once BV_ADMIN_PATH . '/admin_tail.sub.php';
?>