        <footer id="footer"><!--Footer-->
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <p class="pull-left">Copyright © 2019</p>
                        <p class="pull-right">Курс PHP Start</p>
                    </div>
                </div>
            </div>
        </footer><!--/Footer-->


        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="/template/js/jquery.js"></script>
        <script src="/template/js/query-3.3.1.min.js"></script>
        <script src="/template/js/bootstrap.min.js"></script>
        <script src="/template/js/jquery.scrollUp.min.js"></script>
        <script src="/template/js/price-range.js"></script>
        <script src="/template/js/jquery.prettyPhoto.js"></script>
        <script src="/template/js/jquery.cycle2.min.js"></script>
        <script src="/template/js/jquery.cycle2.carousel.min.js"></script>
        <script src="/template/js/main.js"></script>
        <script src="/template/js/custom.js"></script>
        <script>
            $(document).ready(function(){
                //$(element).attr("value");
                $(".add-to-cart").click(function() {
                    let id = $(this).attr('productId');
                    addProduct(id);
                    console.log("В корзину");
                    return false;
                });                
            });        
        </script>
    </body>
</html>
