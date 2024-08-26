import Swiper from "swiper";
import {Navigation} from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";

document.addEventListener("DOMContentLoaded", function() {
    if(document.querySelector(".slider")) {
        const opciones = {
            modules: [Navigation],
            slidesPerView: 1,
            spaceBetween: 15,
            navigation: {
                prevEl: ".swiper-button-prev",
                nextEl: ".swiper-button-next",
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                }
            },
        }

        const swiper = new Swiper(".slider", opciones);
    }
});