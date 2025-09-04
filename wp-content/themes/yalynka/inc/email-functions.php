<?php
// Преобразование JSON корзины в HTML-таблицу в письмах CF7
add_filter('wpcf7_mail_components', function ($components, $contact_form, $mail) {
  if (isset($components['body'])) {
    // Ищем JSON корзины в скрытом поле [cart]
    if (preg_match('/\[(.*?)\]/', $components['body'], $matches)) {
      $json = $matches[1];
      $cart = json_decode($json, true);

      if (is_array($cart)) {
        ob_start(); ?>
        <table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;width:100%">
          <thead>
          <tr>
            <th>Зображення</th>
            <th>Назва</th>
            <th>Кількість</th>
            <th>Ціна</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($cart as $item): ?>
            <tr>
              <td>
                <?php if (!empty($item['image'])): ?>
                  <img src="<?= esc_url($item['image']); ?>" style="max-width:100px;height:auto;">
                <?php endif; ?>
              </td>
              <td><?= esc_html($item['title']); ?></td>
              <td><?= intval($item['quantity']); ?></td>
              <td><?= floatval($item['price']); ?> ₴</td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <?php
        $table = ob_get_clean();

        // Подменяем в теле письма JSON на HTML-таблицу
        $components['body'] = preg_replace('/\[.*?\]/', $table, $components['body']);
      }
    }
  }
  return $components;
}, 10, 3);

