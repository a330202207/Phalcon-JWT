//fastclick 初始化
$(function() {
  FastClick.attach(document.body);

  var currentType = 'weixin'; // 记录当前充值类型

  function getRechargeDta() {
    // $.ajax({
    //   url: postDomain + '/paychan/index',
    //   method: 'get',
    //   data: {

    //   }
    // });
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
      $('.show-btn').text(currentPayInfo[0].title);
      $('.min-fee').text(Number(currentPayInfo[0].min).toFixed(0));
      $('.max-fee').text(Number(currentPayInfo[0].max).toFixed(0));
      $('.count-item').each(function(index, ele) {
        $(ele).find('.number').text('+' + currentPayInfo[0].amount_list[index]);
      });
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
    var currentCount =  Number($('.count-input').val()) || 0;
    var newCount = currentCount + selectCount;
    var maxCount = $('.max-fee').text();

    if(newCount > maxCount) {
      alert('该渠道最高充值' + maxCount + '元');
      return;
    }

    $('.count-input').val(newCount);
  }

  function submitRecharge() {
    var rechargeCount = $('.count-input').val();
    var factName = $('.fact-name').find('input').val();

    if (!rechargeCount) {
      alert('请输入充值金额！');
      return;
    }

    if($('.fact-name')[0].style.display !== 'none' && !factName) {
      alert('请输入您的真实姓名！');
      return;
    }
    console.log(payData.data[currentType][0].channel);

    var postDomain = 'http://login.jndsfs.com';
    $.ajax({
      url: postDomain + '/financial/payment/create',
      method: 'post',
      data: {
        token: 'd3162107d021d06d055f15c6ed18e80e',
        pay_type: currentType,
        os_type: 'iOS',
        money: $('.count-input').val(),
        is_mobile: 'true',
        channel: payData.data[currentType][0].channel
      },
      success: function(data) {
        if(data.status == 0) {
          alert('充值成功!');
        } else {
          alert(data.msg);
        }
      },
      error: function() {
        alert('请求接口出现异常！');
      }
    });
  }

  function clearValue(e) {
    $(e.target).prev().val('');
  }

  // init
  changeContent('weixin');

  $('.pay-btn').on('click', submitRecharge);
  $('.count-item').on('click', setCount);
  $('.clear-count').on('click', clearValue);
});
