        <?php include './header.php';?>
        
        <div style="background-color:#ff6581;height:30px;margin-top:20px;margin-bottom:10px;color:#fff;font-family:黑体;font-size:17px;text-align:left;padding-left:20px;" class="w">
            <?php 
                if(!empty($_REQUEST['cid'])){
                    $cid = $_REQUEST['cid'];
                    $sql = 'select name from category where id='.$cid.' and display=1';
                    echo '>> '.query($sql)[0]['name'].' <<';
                    
                }else{
                    echo 'all babies';
                }
            ?>
        </div>
        <div class="w">
            <div class="c5 font-bold ml20 fl"><a href="./index.php" <?php if(empty($_REQUEST['goods'])) echo 'style="color:#ee3968"';?>>default</a></div>
            <div class="fl"><a href="./index.php?goods=hot" <?php if(@$_REQUEST['goods']=='hot') echo 'style="color:#ee3968"';?> class="font-bold c6">hottest</a></div>
            <div class="fl"><a href="./index.php?goods=price" <?php if(@$_REQUEST['goods']=='price') echo 'style="color:#ee3968"';?> class="font-bold c6">price</a></div>
            <div class="fl"><a href="./index.php?goods=new" class="font-bold c6" <?php if(@$_REQUEST['goods']=='new') echo 'style="color:#ee3968"';?>>latest</a></div>
        </div>
        <div class="clear"></div>
        <div id="body" style="margin-bottom:50px;">
            <div class="w">
                <?php 
                    if(!empty($_REQUEST['cid'])){
                        $sql = "select name,concat(path,id) bpath from category where id = {$cid}";

                        $info = query($sql);
                        $path = $info[0]['bpath'];
                        $cname = $info[0]['name'];
                        $sql = "select * from goods where cate_id in (select id from category where path like '{$path}%') and is_up=1";
                        $sql2 = "select * from goods where cate_id={$_REQUEST['cid']}";
                        if(!$goods = query($sql)){
                            $sql2 = "select * from goods where cate_id={$_REQUEST['cid']} and is_up=1";
                            $goods = query($sql2);
                        }
                    }
                    $i = 0;
                    if(empty($goods)){
                        echo '<div style="color:red;font-family:微软雅黑;font-size:25px;margin-bottom:50px;margin-top:40px;">No relevant data found</div></div>';
                        exit;
                    }
                    foreach($goods as $val){ 
                        $i++;
                        echo '<a href="detail.php?gid='.$val['id'].'">';
                        echo '<div class="ybox fl">';
                        echo '<div class="y1box"><img src="./upload/goods/'.$val['bigimage'].'" width="320" height="194"></div>';
                        echo '<div class="c7">'.$val['name'].'</div>';
                        echo '<div class="c8">'.$val['miaoshu'].'</div>';
                        echo '<div style="text-align:left;border-bottom:1px #dedede solid;"><span class="c9"><span style="font-size:20px;">&yen</span>'.$val['price'].'&nbsp;</span> price<span class="c10">&yen;'.($val['price'] * 1.3).'</span></div>';
                        echo '<div class="c11">'.$val['view'].' viewed</div>';
                        echo '</div>';
                        echo '</a>';
                        if($i%3==0) echo '<div class="clear"></div>';
                    }
                ?>
            </div>
            <div class="clear"></div>

            
        <div class="b5 w">Featured this week</div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
            <?php if ($bzjx):?>
                <?php foreach($bzjx as $val):?>
                    <div class="swiper-slide"><a href="<?php echo APP?>detail.php?gid=<?php echo $val['id']?>"><img src="<?php echo APP?>upload/goods/<?php echo $val['bigimage']?>" alt=""></a></div>
                <?php endforeach;?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <?php endif;?>
        </div>
        </div>

<script src="./swiper.min.js"></script>
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      pagination: {
        // If you need a pager (small dots)
        // Do you need a pager
        el: '.swiper-pagination',
        // Whether to switch to the corresponding image by clicking on the pager is true or false
        clickable: true,
      },
      navigation: {
        // If you need the forward and backward buttons
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });


    var doc = document;
     // Simulate some backend transmission data
     var serviceData = {
         'robot': {
             'name': 'robot001',
             'dialogue': ['mock reply 1', 'mock reply 2', 'mock reply 3'],
             'welcome': 'Hello, robot001 is at your service'
         }
     };
 
     var dialogueInput = doc.getElementById('dialogue_input'),
         dialogueContain = doc.getElementById('dialogue_contain'),
         dialogueHint = doc.getElementById('dialogue_hint'),
         btnOpen = doc.getElementById('btn_open'),
         btnClose = doc.getElementById('btn_close'),
         timer,
         timerId,
         shiftKeyOn = false;  // Assist in determining whether the shift key is held down
 
     btnOpen.addEventListener('click', function(e) {
         $('.dialogue-support-btn').css({'display': 'none'});
         $('.dialogue-main').css({'display': 'inline-block', 'height': '0'});
         $('.dialogue-main').animate({'height': '600px'})
     })
 
     btnClose.addEventListener('click', function(e) {
         $('.dialogue-main').animate({'height': '0'}, function() {
             $('.dialogue-main').css({'display': 'none'});
             $('.dialogue-support-btn').css({'display': 'inline-block'});
         });
     })
 
     dialogueInput.addEventListener('keydown', function(e) {
         var e = e || window.event;
         if (e.keyCode == 16) {
             shiftKeyOn = true;
         }
         if (shiftKeyOn) {
             return true;
         } else if (e.keyCode == 13 && dialogueInput.value == '') {
             // console.log ('Sending content cannot be empty ');
             // Multiple triggers only perform the last fade
             setTimeout(function() {
                 fadeIn(dialogueHint);
                 clearTimeout(timerId);                 
				 timer = setTimeout(function() {
                     fadeOut(dialogueHint)
                 }, 2000);
             }, 10);
             timerId = timer;
             return true;
         } else if (e.keyCode == 13) {
             var nodeP = doc.createElement('p'),
                 nodeSpan = doc.createElement('span');
             nodeP.classList.add('dialogue-customer-contain');
             nodeSpan.classList.add('dialogue-text', 'dialogue-customer-text');
             nodeSpan.innerHTML = dialogueInput.value;
             nodeP.appendChild(nodeSpan);
             dialogueContain.appendChild(nodeP);
             dialogueContain.scrollTop = dialogueContain.scrollHeight;
             submitCustomerText(dialogueInput.value);
         }
     });
 
     dialogueInput.addEventListener('keyup', function(e) {
         var e = e || window.event;
         if (e.keyCode == 16) {
             shiftKeyOn = false;
             return true;
         }
         if (!shiftKeyOn && e.keyCode == 13) {
             dialogueInput.value = null;
         }
     });
 
     function submitCustomerText(text) {
         console.log(text)
         // code here Send text content to the backend
        switch (text) 
        { 
        case 'How is the quality of the iPhone?':
            x="Dear~ Iphones are all authentic products, there is no problem with the quality, and the store has added services such as unconditional return and exchange within 7 days, so you can buy with confidence!"; 
            break; 
        case 'Hello, what is the shopping process like?':
            x="Browse the products and add the baby you want to the shopping cart --> Fill in the order information --> Orders submitted successfully"; 
            break; 
        case 'May I have some discounts?':
            x="Dear, I'm very sorry, the price is the company's regulation, as a small customer service, I have no way to change the price"; 
            break; 
        case 'Placed an order!':
            x="Oh~ your vision is really good, I personally like the one you chose"; 
            break; 
        case 'when will the delivery?':
            x="Dear, we will give priority to delivery as soon as possible, no later than the same day"; 
            break; 
        case 'Ship it as soon as possible, thank you':
            x="No problem, thank you very much for your support to the store"; 
            break; 
        case 6:
            x="今天是星期六"; 
            break; 
        default:
            x="Dear~ Due to the large number of consultants, I am very sorry that I cannot reply to your message in time. You can choose slowly in the store and reply immediately~";
            break;
        }

         //Simulate backend reply
        //  var num = Math.random() * 10;
        //  if (num <= 7) {
        //      getServiceText(serviceData);
        //  }
         getServiceText(x);
     }
 
     function getServiceText(data) {
        //  var serviceText = data.robot.dialogue,
        //      i = Math.floor(Math.random() * serviceText.length);
         var nodeP = doc.createElement('p'),
             nodeSpan = doc.createElement('span');
         nodeP.classList.add('dialogue-service-contain');
         nodeSpan.classList.add('dialogue-text', 'dialogue-service-text');
        //  nodeSpan.innerHTML = serviceText[i];
         nodeSpan.innerHTML = data;
         nodeP.appendChild(nodeSpan);
         dialogueContain.appendChild(nodeP);
         dialogueContain.scrollTop = dialogueContain.scrollHeight;
     }
 
     // fade-out
     function fadeOut(obj) {
         var n = 100;
         var time = setInterval(function() {
             if (n > 0) {
                 n -= 10;
                 obj.style.opacity = '0.' + n;
             } else if (n <= 30) {
                 obj.style.opacity = '0';
                 clearInterval(time);
             }
         }, 10);
         return true;
     }
 
     // fade in
     function fadeIn(obj) {
         var n = 30;
         var time = setInterval(function() {
             if (n < 90) {
                 n += 10;
                 obj.style.opacity = '0.' + n;
             } else if (n >= 80) {
                 
                 obj.style.opacity = '1';
                 clearInterval(time);
             }
         }, 100);
         return true;
     }
  </script>