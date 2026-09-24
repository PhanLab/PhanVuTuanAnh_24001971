<?php
    class CartItem
    {
        private $name;
        private $price;
        private $quantity;

        public function __construct($name, $price, $quantity)
        {
            $this->name = $name;
            $this->price = $price;
            $this->quantity = $quantity;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getPrice()
        {
            return $this->price;
        }

        public function getQuantity()
        {
            return $this->quantity;
        }

        public function getTotal()
        {
            return $this->price * $this->quantity;
        }
    }

    class ShoppingCart
    {
        private $items = []; // Array to hold CartItem objects

        public function addItem($item)
        {
            if ($item->getPrice() <= 0)
            {
                echo "Lỗi: Giá sản phẩm phải lớn hơn 0<br>";
                return;
            }

            if ($item->getQuantity() <= 0)
            {
                echo "Lỗi: Số lượng sản phẩm phải lớn hơn 0<br>";
                return;
            }

            $this->items[] = $item;

            echo "Đã thêm sản phẩm: " . $item->getName() . "<br>";
        }

        public function removeItem($name)
        {
            foreach ($this->items as $index => $item)
            {
                if ($item->getName() === $name)
                {
                    unset($this->items[$index]);

                    echo "Đã xóa sản phẩm: $name<br>";
                    return;
                }
            }

            echo "Không tìm thấy sản phẩm: $name<br>";
        }

        public function calculateTotal()
        {
            $total = 0;

            foreach ($this->items as $item)
            {
                $total += $item->getTotal();
            }

            return $total;
        }

        public function displayCart()
        {
            if (empty($this->items))
            {
                echo "Giỏ hàng đang trống.<br>";
                return;
            }

            echo "<h3>Danh sách sản phẩm</h3>";

            echo "<table border='1' cellpadding='8'>";
            echo "<tr>";
            echo "<th>Tên sản phẩm</th>";
            echo "<th>Đơn giá</th>";
            echo "<th>Số lượng</th>";
            echo "<th>Thành tiền</th>";
            echo "</tr>";

            foreach ($this->items as $item)
            {
                echo "<tr>";
                echo "<td>" . $item->getName() . "</td>";
                echo "<td>" . number_format($item->getPrice()) . " VND</td>";
                echo "<td>" . $item->getQuantity() . "</td>";
                echo "<td>" . number_format($item->getTotal()) . " VND</td>";
                echo "</tr>";
            }

            echo "</table>";

            echo "<p><strong>Tổng tiền: "
                . number_format($this->calculateTotal())
                . " VND</strong></p>";
        }
    }



    // ================================
    // CHUONG TRINH CHINH
    // ================================

    // 1. Tạo một object ShoppingCart
    $cart = new ShoppingCart();


    // 2. Tạo ít nhất 04 object CartItem
    $item1 = new CartItem("Laptop", 15000000, 1);
    $item2 = new CartItem("Mouse", 500000, 2);
    $item3 = new CartItem("Keyboard", 1000000, 1);
    $item4 = new CartItem("Headphones", 1200000, 2);


    // 3. Thêm các sản phẩm vào giỏ hàng bằng method addItem()
    $cart->addItem($item1);
    $cart->addItem($item2);
    $cart->addItem($item3);
    $cart->addItem($item4);


    // 4. Hiển thị toàn bộ giỏ hàng
    echo "<h2>Giỏ hàng ban đầu</h2>";

    $cart->displayCart();


    // 5. Tính và hiển thị tổng tiền của giỏ hàng
    echo "<h3>Tổng tiền giỏ hàng:</h3>";

    echo number_format($cart->calculateTotal()) . " VND";


    // 6. Xóa một sản phẩm theo tên bằng method removeItem()
    echo "<h3>Xóa sản phẩm:</h3>";

    $cart->removeItem("Keyboard");


    // 7. Hiển thị lại giỏ hàng sau khi xóa
    echo "<h2>Giỏ hàng sau khi xóa</h2>";

    $cart->displayCart();
?>