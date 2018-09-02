//fastclick 初始化
$(function() {
  FastClick.attach(document.body);
  document.getElementsByTagName("body").ontouchmove = function(e) {
    e.preventDefault();
  }

  var currentType = ''; // 记录当前充值类型
  var timer = null; // alert倒计时对象
  var countDown = 5; // 倒计时秒数

  function isIOS() {
    var u = navigator.userAgent;
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
    return isiOS;
  }

  if (isIOS()) {
    $('.recharge-history-modal').css('height', '7rem');
  }

  // 根据返回信息初始化显示渠道菜单
  function initMenu() {
    $('.menu-item').each(function(index, ele) {
      var type = $(ele).data('type');
      if (payData.data[type] && payData.data[type].length <= 0) {
        $(ele).hide();
      } else if (!currentType) {
        currentType = type;
        var firstMenu = $(".menu-item[data-type=" + type + "]");
        var cls = firstMenu.attr('class').replace(/up/, "down");
        firstMenu.attr('class', cls);
      }
    });
  }

  function getCurrentPay(data, currentKey) {
    for (key in data) {
      if (currentKey === key) {
        return data[key];
      }
    }
    return '';
  }

  function showAgent() {
    $('.agent-info').show();
    $('.logo-container').hide();
    $('.opration-area').hide();
    $('.submit-area').hide();
  }

  function changeContent(type) {
    var currentPayInfo = getCurrentPay(payData.data, type);
    if (!currentPayInfo) {
      return;
    }

    $('.recharge-logo').hide();
    $('.recharge-role').hide();
    $('.logo-container').show();
    $('.opration-area').show();
    $('.agent-info').hide();
    $('.opration-area ').removeClass('opration-area-empty');

    if (type === 'weixin' || type === 'wc2bank') {
      $('.logo_pay_wechat').show();
      $('.logo_pay_wechat01').show();
    } else if (type === 'alipay' || type === 'alipay2bank') {
      $('.logo_pay_zfb').show();
      $('.logo_pay_zfb01').show();
    } else if (type === 'unpay') {
      $('.logo_pay_union').show();
      $('.logo_pay_union01').show();
    }
    if (currentPayInfo && currentPayInfo.length > 0) {
      var maxCount = Number(currentPayInfo[0].max).toFixed(0);
      $('.show-btn').text(currentPayInfo[0].title);
      $('.min-fee').text(Number(currentPayInfo[0].min).toFixed(0));
      $('.max-fee').text(maxCount);
      $('.count-item').each(function(index, ele) {
        $(ele).find('.number').text('+' + currentPayInfo[0].amount_list[index]);
      });
      if (Number($('.count-input').val()) > maxCount) {
        showAlert('该渠道最高充值' + maxCount + '元');
        $('.count-input').val(maxCount);
      }
      $('.has-content').show();
      $('.no-content').hide();
      $('.submit-area').show();
    } else {
      $('.opration-area ').addClass('opration-area-empty');
      $('.has-content').hide();
      $('.no-content').show();
      $('.submit-area').hide();
    }
    if (type === 'weixin' || type === 'alipay') {
      $('.tip').show();
      $('.fact-name').hide();
    } else {
      $('.tip').hide();
      $('.fact-name').show();
    }
  }

  //tab切换事件监听
  $(document).on("click", '.popup-content-left div', function() {
    $(".popup-content-left div").each(function() {
      var class_list = $(this).attr('class');
      var newclass = class_list.replace(/down/, "up");
      $(this).attr('class', newclass);
    })
    var class_list = $(this).attr('class');
    var newclass = class_list.replace(/up/, "down");
    $(this).attr('class', newclass);

    var type = $(this).data('type');
    currentType = type;
    type !== 'vippay' ? changeContent(type) : showAgent();
    // $(".popup-content-list").css("display","none");
    // $(".popup-content-list").eq($(this).index()).css("display","block");
  })

  function setCount(e) {
    var selectCount = Number($(e.target).parent().find('.number').text().split('+')[1]);
    var currentCount = Number($('.count-input').val()) || 0;
    var newCount = currentCount + selectCount;
    var maxCount = $('.max-fee').text();

    if (newCount > maxCount) {
      newCount = maxCount;
      showAlert('该渠道最高充值' + maxCount + '元');
    }

    $('.count-input').val(newCount);
  }

  function submitRecharge() {
    var rechargeCount = $('.count-input').val();
    var factName = $('.fact-name').find('input').val();
    var minCount = $('.min-fee').text();

    if (!rechargeCount) {
      showAlert('请输入充值金额！');
      return;
    }

    if (rechargeCount < minCount) {
      showAlert('该渠道最低充值' + minCount + '元');
      $('.count-input').val(minCount);
      return;
    }

    if ($('.fact-name')[0].style.display !== 'none' && !factName) {
      showAlert('请输入您的真实姓名！');
      return;
    }
    console.log(payData.data[currentType][0].channel);

    var postDomain = 'http://login.jndsfs.com';
    $.ajax({
      url: postDomain + '/financial/payment/create',
      method: 'post',
      data: {
        token: payData.token,
        pay_type: currentType,
        os_type: payData.os_type,
        money: rechargeCount,
        is_mobile: payData.is_mobile,
        channel: payData.data[currentType][0].channel
      },
      success: function(data) {
        if (data.status == 0) {
          // do nothing
        } else {
          showAlert(data.msg);
        }
      },
      error: function() {
        showAlert('请求接口出现异常！');
      }
    });
  }

  function clearValue(e) {
    e.stopPropagation();
    $(e.target).prev().val('');
  }

  function showRangeSelect(e) {
    e.stopPropagation();
    $('.custom-select').show();
    var currentCount = $('.count-input').val() || 0;
    if (currentCount > 0) {
      var rate = (currentCount / $('.max-fee').text()).toFixed(2);
      var moveWidth = $('.option-move').width();
      var distance = moveWidth * rate;
      // if (distance < 0) {
      //   distance = 0;
      // }
      // if(distance > moveWidth) {
      //   distance = moveWidth - 10;
      // }
      $('.move-inner').width(distance);
      // var barLeft = distance != 0 ? distance - 10 : 0;
      var barLeft = distance < 10 ? -5 : distance - 15;
      $('.move-bar').css('left', barLeft + 'px');
    }
  }

  function hideRangeSelect() {
    $('.custom-select').hide();
    $('.whole-screen-layer').hide();
  }

  function deleteNum(e) {
    var currentCount = $('.count-input').val();
    if (currentCount) {
      var splitNum = currentCount.length - 1;
      $('.count-input').val(currentCount.substr(0, splitNum));
      showRangeSelect(e);
    }
  }

  function customeAdjustCount(e) {
    var touch = e.originalEvent.targetTouches[0];
    // console.log(touch.pageX, $('.option-move').offset().left, $('.option-move').width());
    // var moveDistance = parseInt(touch.pageX - $('.option-move').offset().left) / $('.option-move').width() * 100;
    var moveDistance = touch.pageX - $('.option-move').offset().left;
    var barLeft = moveDistance - 10;
    var totalWidth = $('.option-move').width();
    var rate = (moveDistance / totalWidth).toFixed(2);

    if (moveDistance > totalWidth) {
      moveDistance = totalWidth;
      barLeft = totalWidth - 15;
    }
    if (moveDistance < 0) {
      moveDistance = 0;
      barLeft = 0;
    }
    $('.move-inner').css('width', moveDistance + 'px');
    $('.move-bar').css('left', barLeft + 'px');

    var maxCount = $('.max-fee').text();
    var minCount = Number($('.min-fee').text()) > 1 ? $('.min-fee').text() : 1;
    var currentCount = parseInt(maxCount * rate);
    if (currentCount > maxCount) {
      currentCount = maxCount;
    }
    if (currentCount <= minCount) {
      currentCount = minCount;
    }

    $('.count-input').val(currentCount);
  }

  function appendCount(e) {
    var selectNum = $(e.target).text();
    if (!isNaN(Number(selectNum))) {
      var newCount = Number($('.count-input').val() + selectNum);
      var maxCount = Number($('.max-fee').text());
      if (newCount > maxCount) {
        newCount = maxCount;
        showAlert('该渠道最高充值' + maxCount + '元');
      }
      $('.count-input').val(newCount);
      showRangeSelect(e);
    } else {
      selectNum == '确定' ? hideRangeSelect() : deleteNum(e);
    }
  }

  function subtractionCount(e) {
    var count = Number($('.count-input').val());
    var newCount = count > 1 ? count - 1 : 1;
    $('.count-input').val(newCount);
    showRangeSelect(e);
  }

  function addCount(e) {
    var count = Number($('.count-input').val());
    var maxCount = Number($('.max-fee').text());
    var newCount = count < maxCount ? count + 1 : maxCount;
    $('.count-input').val(newCount);
    showRangeSelect(e);
  }

  function showReportReward() {
    $('.report-reward-modal-wrapper').show();
  }

  function hideReportReward() {
    $('.report-reward-modal-wrapper').hide();
  }

  function showHistory() {
    $('.recharge-history-modal-wrapper').show();
  }

  function hideHistory() {
    $('.recharge-history-modal-wrapper').hide();
  }

  function toggleFilterList() {
    $('.filter-list').slideToggle(200);
  }

  function showAlert(info) {
    $('.alert-text').text(info);
    $('.time').text(countDown);
    timer = setInterval(function() {
      countDown--;
      $('.time').text(countDown);
      if (countDown === 0) {
        hideAlert();
      }
    }, 1000);
    $('.alert-modal-wrapper').show();
  }

  function hideAlert(info) {
    $('.alert-modal-wrapper').hide();
    clearInterval(timer);
    timer = null;
    countDown = 5;
  }

  // init
  initMenu();
  changeContent(currentType);

  //事件注册
  $('.pay-btn').on('click', submitRecharge);
  $('.count-item').on('click', setCount);
  $('.clear-count').on('click', clearValue);
  $('.input-count').on('click', showRangeSelect);
  $('.option-move').on('touchstart', customeAdjustCount);
  $('.option-move').on('touchmove', customeAdjustCount);
  $('.num-item').on('click', appendCount);
  $('.option-subtraction').on('click', subtractionCount);
  $('.option-add').on('click', addCount);
  $('.history-btn').on('click', showHistory);
  $('.close-recharge-history').on('click', hideHistory);
  $('.report-reward').on('click', showReportReward);
  $('.close-report-reward').on('click', hideReportReward);
  $('.filter-area').on('click', toggleFilterList);
  $('.confirm-btn').on('click', hideAlert);
  $('#popup').on('click', function() {
    hideRangeSelect();
  });
  $('.custom-select').on('click', function(e) {
    e.stopPropagation();
  });
});
