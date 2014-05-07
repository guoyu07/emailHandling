<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <!--This class is showing the template and have text box for entering the subject of emails and also tolist
    Also it call insert function to insert the final emails into two tables of emailtemplatelog and sent emails-->
    <body>
        <!-- Box -->
        <div class="box">
            <!-- Box Head -->
            <div class="box-head">
                <h2>Show Email</h2>
            </div>
            <!-- End Box Head -->

            <form action="InsertMessageTable.php" method="post">
                <!-- Form -->
                <div class="form">
                    <p>
                        <label>Email ID </label>
                        <input type="text" name="ID" class="field size1" />
                    </p>

                    <p>
                        <label> subject </label>
                        <input type="text" name="subject" class="field size1" />
                    </p>

                    <p>
                        <label>Email To list </label>
                        <input type="text" name="tolist" class="field size1" />
                    </p>
                    <p>
                        <textarea class="field size1" name="body" rows="30" cols="30">
                            <?php echo $template; ?>
                        </textarea>
                    </p>
                </div>
                <!-- End Form -->

                <!-- Form Buttons -->
                <div class="buttons">
                    <input type="submit" class="button" value="submit" />
                </div>
                <!-- End Form Buttons -->
            </form>
        </div>
        <!-- End Box -->

        <!-- Sidebar -->
        <div id="sidebar">
            <!-- Box -->
            <div class="box">
                <!-- Box Head -->
                <div class="box-head">

                </div>
                <!-- End Box -->
            </div>
            <!-- End Sidebar -->

            <div class="cl">&nbsp;</div>
        </div>
        <!-- Main -->
        <!-- End Container -->

        <!-- Footer -->
        <div id="footer">
            <div class="shell">
                <span class="left"></span>
                <span class="right">
                    <a href="images/footer.gif" target="_blank" title=""></a>
                </span>
            </div>
        </div>
        <!-- End Footer -->
    </body>
</html>


