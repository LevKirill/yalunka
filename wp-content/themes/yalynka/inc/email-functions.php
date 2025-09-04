<?php
add_action('wpcf7_before_send_mail', function($contact_form, &$abort, $submission){
  $submission = WPCF7_Submission::get_instance();
  if(!$submission) return;

  $data = $submission->get_posted_data();
  if(empty($data['cart'])) return;

  $cart = json_decode(stripslashes($data['cart']), true);
  if(!$cart) return;

  $itemsHtml = '';
  $total = 0;

  foreach($cart as $item){
    $title = sanitize_text_field($item['title']);
    $price = floatval($item['price']);
    $quantity = isset($item['quantity']) ? intval($item['quantity']) : 1;
    $img = esc_url($item['image']);

    $itemsHtml .= '<tr>';
    $itemsHtml .= "<td><img src='{$img}' style='max-width:100px; height:auto;'></td>";
    $itemsHtml .= "<td>{$title}</td>";
    $itemsHtml .= "<td>{$quantity}</td>";
    $itemsHtml .= "<td>{$price} ₴</td>";
    $itemsHtml .= '</tr>';

    $total += $price;
  }

  // Добавляем фильтр, чтобы заменить [cart] на HTML таблицы
  add_filter('wpcf7_mail_components', function($components) use ($itemsHtml, $total) {
    $components['body'] = str_replace('[cart]', $itemsHtml, $components['body']);
    $components['body'] = str_replace('[total]', $total . ' ₴', $components['body']);
    return $components;
  });
}, 10, 3);
