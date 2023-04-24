
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php
              echo form_open();
            ?>
              <h1>Login Form</h1>
              <?php
                if(isset($message)){
                 echo '<p class="validations_error text-danger">';
                  echo $message;
                  echo '</p>';
                }
                if(validation_errors())
                {
                  echo '<div class="validations_error  text-red">';
                  echo validation_errors();
                  echo '</div>';
                }
              ?>
              <div>
                <?php
                  echo form_input(
                      array(
                          'name' => 'u_name',
                          'value' => set_value('u_name'),
                          'class' => 'form-control',
                          'placeholder' => 'Username',
                        )
                    );
                ?>
              </div>
              <div>
                <?php
                  echo form_password(
                      array(
                          'name' => 'u_pass',
                          'value' => set_value('u_pass'),
                          'class' => 'form-control',
                          'placeholder' => 'Password',
                        )
                    );
                ?>
              </div>
              <div>
                <button class="btn btn-default submit">Log in</button>
<!--                 <a class="reset_pass" href="#">Lost your password?</a>
               -->              </div>

   
            
           
        <br />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
   
    <script src='https://www.google.com/recaptcha/api.js'></script>
        <br />
        
                <?php
                if($this->session->flashdata('message'))
                {
                ?>
                    <div class="alert alert-danger">
                        <?php
                        echo $this->session->flashdata('message');
                        ?>
                    </div>
                <?php
                }

                if($this->session->flashdata('success_message'))
                {
                ?>
                    <div class="alert alert-success">
                        <?php
                        echo $this->session->flashdata('success_message');
                        ?>
                    </div>
                <?php
                }
                ?>
                <form method="post" action="<?php echo base_url(); ?>captcha/validate">
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LfMUa8lAAAAACcYTf4XiVuNGH2YCaqlpq1K4aVi"></div>
                    </div>
                    
                </form>
             
    
         

              <div class="clearfix"></div>

            <?php
              echo form_close();
            ?>
          </section>
        </div>
      </div>