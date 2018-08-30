<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>充值</title>
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/recharge.css">
</head>

<body>
  <div id="popup">
    <img id="popup-close" src="../../img/window_close.png" />
    <div class="popup-title ui_lobby_payvalue bg_payval_title popup-title-recharge">
      <div class="ui_lobby_payvalue title_pay"></div>
    </div>
    <div class="popup-content bg_inner_window">
      <div class="left popup-content-left">
        <div class="ui_lobby_payvalue button_pay_wechat_down" data-type="weixin"></div>
        <div class="ui_lobby_payvalue button_lobby_pay_zfbzyhk_up" data-type="alipay2bank"></div>
        <div class="ui_lobby_payvalue button_lobby_pay_wxzyhk_up" data-type="wc2bank"></div>
        <div class="ui_lobby_payvalue button_lobby_pay_union_up" data-type="unpay"></div>
        <div class="ui_lobby_payvalue button_lobby_payval_agentpay_up" data-type="vippay"></div>
        <div class="ui_lobby_payvalue button_pay_zfb_up" data-type="alipay"></div>
      </div>
      <div class="right popup-content-right window_inner">
        <div class="popup-content-list">
          <div class="ui_lobby_payvalue logo_pay_bg">
            <div class="logo-container">
              <div class="ui_lobby_payvalue logo_pay_zfb recharge-logo"></div>
              <div class="ui_lobby_payvalue logo_pay_zfb01 recharge-role"></div>
              <div class="ui_lobby_payvalue logo_pay_qq recharge-logo none"></div>
              <div class="ui_lobby_payvalue logo_pay_qq01 recharge-role none"></div>
              <div class="ui_lobby_payvalue logo_pay_union recharge-logo none"></div>
              <div class="ui_lobby_payvalue logo_pay_union01 recharge-role none"></div>
              <div class="ui_lobby_payvalue logo_pay_wechat recharge-logo none"></div>
              <div class="ui_lobby_payvalue logo_pay_wechat01 recharge-role none"></div>
            </div>
            <div class="opration-area">
              <div class="has-content">
                <div class="show-info">
                  <div>持有金币：<span class="count">6.34</span></div>
                  <div>银行金币：<span class="count">0</span></div>
                  <div class="proportion">充值比例：1元=1金币</div>
                </div>
                <div class="ui_lobby_payvalue button_lobby_payvalue_channel_down show-btn">支付宝</div>
                <div class="recharge-count">
                  <div class="input-count">
                    <input type="text" class="bg_input count-input" placeholder="自定义充值金额">
                    <span class="ui_lobby_payvalue ui_lobby_pay_btn_close clear-count"></span>
                  </div>
                  <div class="recharge-range">充值范围：(<span class="min-fee">1</span>-<span class="max-fee">4000</span>)</div>
                </div>
                <div class="recharge-prompt">温馨提示：如果您的支付方式不稳定，请选择其他支付方式。</div>
                <ul class="count-list">
                  <li class="count-item">
                    <img src="../../img/recharge_count.png" class="count-image">
                    <span class="number">+100</span>
                  </li>
                  <li class="count-item">
                    <img src="../../img/recharge_count.png" class="count-image">
                    <span class="number">+100</span>
                  </li>
                  <li class="count-item">
                    <img src="../../img/recharge_count.png" class="count-image">
                    <span class="number">+100</span>
                  </li>
                  <li class="count-item">
                    <img src="../../img/recharge_count.png" class="count-image">
                    <span class="number">+100</span>
                  </li>
                  <li class="count-item">
                    <img src="../../img/recharge_count.png" class="count-image">
                    <span class="number">+100</span>
                  </li>
                  <li class="count-item">
                    <img src="../../img/recharge_count.png" class="count-image">
                    <span class="number">+100</span>
                  </li>
                </ul>
              </div>
              <div class="no-content none">暂时没有充值渠道，请稍后选择其他充值方式</div>
            </div>
            <div class="agent-info">
              <div class="user-info">
                <input type="text" class="bg_input user-id" disabled>
                <span class="copy-btn">复制</span>
              </div>
              <div class="warn-area">
                <div class="warn-text">已上联系方式均为本游戏金牌代理，充值不稳定时可用代理充值，添加任意代理微信或QQ，可在10秒内帮您完成充值。</div>
                <div class="ui_lobby_payvalue button_lobby_pay_refresh_up refresh-btn"></div>
              </div>
            </div>
          </div>
          <div class="submit-area">
            <div class="tip-name">
              <span class="tip">提示：充值最低1元，需要安装支付宝或者微信客户端</span>
              <div class="fact-name none">
                <input type="text" class="bg_input" placeholder="请输入您的真实姓名">
                <span class="ui_lobby_payvalue ui_lobby_pay_btn_close clear-count"></span>
              </div>
            </div>
            <div style="flex: 1;clear: both;overflow: hidden;">
              <div class="button_round1_up_x button_round1 pay-btn">
                <span class="vertical_center">确认充值</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="../../js/jquery-2.1.4.min.js"></script>
<script src="../../js/fastclick.js"></script>
<script type="text/javascript" src="../../js/rem.js"></script>
<script type="text/javascript">
  var payData = {{data}};
  console.log(payData);
</script>
<script src="../../js/index.js"></script>
</html>
