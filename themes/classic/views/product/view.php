<?php $this->layout='column1'; ?>

<div class="content_bg">
  	<div class="content_center">
      	<div class="content">
          	<div class="more">
                  <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                      'links'=>$this->breadcrumbs,
                  )); ?>
                  <div class="more_l">
                  	<div class="more_pics">
                          <div class="small">
                          	<a href="#"><img src="pic/more1.png" /></a>
                          </div>
                          <div class="small">
                          	<a href="#"><img src="pic/more2.png" /></a>
                          </div>
                          <div class="small">
                          	<a href="#"><img src="pic/more3.png" /></a>
                          </div>
                      </div>
                      <div class="more_pic">
                      	<a href="#"><img src="pic/more.png" /></a>
                      </div>
                      <div class="more_pic_button">
                      	<a href="#"><img src="images/enlarge_icon.png" /></a>
                      </div>
                  </div>
                  <div class="more_r">
                  	<h1>CHOCOLATE PEDAL PUSHERS</h1>
                      <div class="more_l_l">
                          <div class="more_r_price">
                              <?php echo Yii::app()->priceFormatter->templateFormat('{int}<sup>{currency}</sup>', $product->price); ?>
                          </div>
                          <div class="old_price">
                          	<div>Старая цена</div>
                              <?php echo Yii::app()->priceFormatter->templateFormat('{int}<sup>{currency}</sup>', $product->other_price); ?>
                          </div>
                          <b class="clearb"></b>
                          <div class="more_r_opt">
                              оптовая
                              <strong>480</strong>
                              за уп.
                          </div>
                      </div>
                      <div class="more_l_r">
                      	<input class="cart_buy" onclick="$.putToCart(<?php echo $product->id; ?>)" type="submit" value  />
                          <b class="clearb"></b>
                          <label><input type="radio" />оптом 480 грн.</label>
                      </div>
                      <div class="info">
                      	Размер
                          <select>
                              <option>S</option>
                              <option>M</option>
                              <option>L</option>
                              <option>XL</option>
                          </select>
                      </div>
                      <div class="info">
                      	Размеры в упаковке: XS, S, M, L, XL, XXL, XXXL
                      </div>
                      <div class="info">
                      	<span>Доступные цвета:</span>
                          <div class="color"><a href="#"><img src="images/color1.png" /></a></div>
                          <div class="color"><a href="#"><img src="images/color2.png" /></a></div>
                          <div class="color"><a href="#"><img src="images/color3.png" /></a></div>
                          <div class="color"><a href="#"><img src="images/color4.png" /></a></div>
                          <div class="color"><a href="#"><img src="images/color5.png" /></a></div>
                      </div>
                      <div class="description_nav">
                      	<ul>
                          	<li class="active"><a href="#">ОПИСАЕНИЕ</a></li>
                              <li><a href="#">РАЗМЕРЫ</a></li>
                          </ul>
                      </div>
                      <div class="description">
                      Футболка с принтом – способ самовыражения.
  И вряд ли кто-то со мной поспорит. Принт на футболке, как статус в icq, выражает твое настроение и внутренний мир. К чему-то призывает, либо просто улыбает.
                      </div>
                  </div>
                  <div class="other">
                  	<div class="other_head">
                      	Рекомендуемые товары
                      </div>
                      <a href="#"><div class="catalog_item">
                      	<div class="catalog_item_pic">
                          	<img src="pic/catalog7.png" />
                          </div>
                          <div class="catalog_item_price">
                          	160
                              <sup>грн</sup>
                          </div>
                          <div class="catalog_item_opt">
                          	оптовая
                              <strong>480</strong>
                              за уп.
                          </div>
                          <h1>CHOCOLATE PEDAL PUSHERS</h1>
                      </div></a>
                      <a href="#"><div class="catalog_item">
                      	<div class="catalog_item_pic">
                          	<img src="pic/catalog8.png" />
                          </div>
                          <div class="catalog_item_price">
                          	160
                              <sup>грн</sup>
                          </div>
                          <div class="catalog_item_opt">
                          	оптовая
                              <strong>480</strong>
                              за уп.
                          </div>
                          <h1>CHOCOLATE PEDAL PUSHERS</h1>
                      </div></a>
                      <a href="#"><div class="catalog_item">
                      	<div class="catalog_item_pic">
                          	<img src="pic/catalog9.png" />
                          </div>
                          <div class="catalog_item_price">
                          	160
                              <sup>грн</sup>
                          </div>
                          <div class="catalog_item_opt">
                          	оптовая
                              <strong>480</strong>
                              за уп.
                          </div>
                          <h1>CHOCOLATE PEDAL PUSHERS</h1>
                      </div></a>
                      <a href="#"><div class="catalog_item">
                      	<div class="catalog_item_pic">
                          	<img src="pic/catalog9.png" />
                          </div>
                          <div class="catalog_item_price">
                          	160
                              <sup>грн</sup>
                          </div>
                          <div class="catalog_item_opt">
                          	оптовая
                              <strong>480</strong>
                              за уп.
                          </div>
                          <h1>CHOCOLATE PEDAL PUSHERS</h1>
                      </div></a>
                  </div>
                  <div class="other">
                  	<div class="other_head">
                      	Другие предложения
                      </div>
                      <a href="#"><div class="catalog_item">
                      	<div class="catalog_item_pic">
                          	<img src="pic/catalog7.png" />
                          </div>
                          <div class="catalog_item_price">
                          	160
                              <sup>грн</sup>
                          </div>
                          <div class="catalog_item_opt">
                          	оптовая
                              <strong>480</strong>
                              за уп.
                          </div>
                          <h1>CHOCOLATE PEDAL PUSHERS</h1>
                      </div></a>
                      <a href="#"><div class="catalog_item">
                      	<div class="catalog_item_pic">
                          	<img src="pic/catalog8.png" />
                          </div>
                          <div class="catalog_item_price">
                          	160
                              <sup>грн</sup>
                          </div>
                          <div class="catalog_item_opt">
                          	оптовая
                              <strong>480</strong>
                              за уп.
                          </div>
                          <h1>CHOCOLATE PEDAL PUSHERS</h1>
                      </div></a>
                      <a href="#"><div class="catalog_item">
                      	<div class="catalog_item_pic">
                          	<img src="pic/catalog9.png" />
                          </div>
                          <div class="catalog_item_price">
                          	160
                              <sup>грн</sup>
                          </div>
                          <div class="catalog_item_opt">
                          	оптовая
                              <strong>480</strong>
                              за уп.
                          </div>
                          <h1>CHOCOLATE PEDAL PUSHERS</h1>
                      </div></a>
                      <a href="#"><div class="catalog_item">
                      	<div class="catalog_item_pic">
                          	<img src="pic/catalog9.png" />
                          </div>
                          <div class="catalog_item_price">
                          	160
                              <sup>грн</sup>
                          </div>
                          <div class="catalog_item_opt">
                          	оптовая
                              <strong>480</strong>
                              за уп.
                          </div>
                          <h1>CHOCOLATE PEDAL PUSHERS</h1>
                      </div></a>
                  </div>
              </div>
          </div>
      </div>
  </div>