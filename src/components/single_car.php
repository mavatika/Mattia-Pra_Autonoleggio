<?php

function createCar(array $car) {
    return '<article class="single_car" aria-roledescription="car element">
    <figure class="single_car_image">
        <img src="' . $car['image'] . '" alt="' . $car['brand'] . ' ' . $car['model'] . '">
        <div class="single_car_price" role="contentinfo">
            <span class="euro">€</span> <span class="price">' . $car['price'] . '</span>
            <span class="day">/day</span>
        </div>
    </figure>
    <div class="single_car_description">
        <h2>' . $car['brand'] . ' ' . $car['model'] . '</h2>
        <div class="car_details" role="group">
            <div class="single_detail" title="Speed">
                <div class="icon_wrapper">
                    <img src="/img/pages/cars/icons/speed.svg" alt="">
                </div>
                <span>' . $car['speed'] . ' CV</span>
            </div>
            <div class="single_detail" title="Seats">
                <div class="icon_wrapper" role="presentation">
                    <img src="/img/icons/users.svg" alt="">
                </div>
                <span>' . $car['seats'] . '</span>
            </div>
            <div class="single_detail" title="Engine">
                <div class="icon_wrapper" role="presentation">
                    <img src="/img/icons/zap.svg" alt="">
                </div>
                <span>' . $car['engine'] . '</span>
            </div>
        </div>
    </div>
    <button type="submit" name="id" value="' . $car['id'] . '" class="primary_btn" title="I want this one">Rent</button>
    </article>';
}

?>