<div class="container px-3 md-px-0">
    <div class="row">
        <div class="text-center">
            <h3>APPLICATION FORM FOR ADMISSION TO M.B.B.S. DEGREE COURSE</h3>
        </div>
    </div>
    <form id="form1" action="<?php echo site_url('temporary_user/TemporaryUser/create') ?>" id="employeeform" name="employeeform" method="post" accept-charset="utf-8" enctype="multipart/form-data">

        <div class="row bg-secondary rounded-top p-3">
            <div class="text-white p-2 text-center text-md-start">
                <span class="fw-bold ">Student Details</span>
            </div>
        </div>
        <div class="row bg-light rounded-bottom shadow p-3 mb-4">
            <?php if ($this->session->flashdata('msg')) { ?>
                <?php echo $this->session->flashdata('msg') ?>
            <?php } ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('admission_no'); ?></label> <small class="text-danger"> *</small>
                        <input autofocus="" id="admission_no" name="admission_no" placeholder="" type="text" class="form-control" value="<?php echo set_value('admission_no', $student_data->admission_no); ?>" />
                        <span class="text-danger"><?php echo form_error('admission_no'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <?php echo "Centre/Board Reg Number"; ?></label>
                        <small class="text-danger"></small>
                        <input id="kuhs_reg" name="kuhs_reg" placeholder="" type="text" class="form-control" value="<?php echo set_value('kuhs_reg', $student_data->kuhs_reg); ?>" />
                        <span class="text-danger"><?php echo form_error('kuhs_reg'); ?></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('roll_no'); ?></label>
                        <input id="roll_no" name="roll_no" placeholder="" type="text" class="form-control" value="<?php echo set_value('roll_no', $student_data->roll_no); ?>" />
                        <span class="text-danger"><?php echo form_error('roll_no'); ?></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="text-danger"> *</small>
                        <select id="class_id" name="class_id" class="form-control">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <?php
                            foreach ($classlist as $class) {
                            ?>
                                <option value="<?php echo $class['id'] ?>" <?php
                                                                            if ($student_data->class_id == $class['id']) {
                                                                                echo "selected =selected";
                                                                            }
                                                                            ?>><?php echo $class['class'] ?></option>
                            <?php
                                $count++;
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="text-danger"> *</small>
                        <select id="section_id" name="section_id" class="form-control">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <?php
                            foreach ($section as $sec) {
                            ?>
                                <option value="<?php echo $sec['id'] ?>" <?php
                                                                            if ($student_data->section_id == $sec['id']) {
                                                                                echo "selected =selected";
                                                                            }
                                                                            ?>><?php echo $sec['section'] ?></option>
                            <?php
                                $count++;
                            }
                            ?>
                        </select>

                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('first_name'); ?></label><small class="text-danger"> *</small>
                        <input id="firstname" name="firstname" placeholder="" type="text" class="form-control" value="<?php echo set_value('firstname', $student_data->firstname); ?>" />
                        <span class="text-danger"><?php echo form_error('firstname'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('last_name'); ?></label>
                        <input id="lastname" name="lastname" placeholder="" type="text" class="form-control" value="<?php echo set_value('lastname', $student_data->lastname); ?>" />
                        <span class="text-danger"><?php echo form_error('lastname'); ?></span>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputFile"> <?php echo $this->lang->line('gender'); ?></label><small class="text-danger"> *</small>
                        <select class="form-control" name="gender">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <?php
                            foreach ($genderList as $key => $value) {
                            ?>
                                <option value="<?php echo $key; ?>" <?php if ($student_data->gender == $key) echo "selected"; ?>><?php echo $value; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('gender'); ?></span>
                    </div>
                </div>

            </div>
            <div class="row">



                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('date_of_birth'); ?></label><small class="text-danger"> *</small>
                        <input id="dob" name="dob" placeholder="" type="date" class="form-control" value="<?php echo set_value('dob', $student_data->dob); ?>" onchange="calculateAge()" />
                        <span class="text-danger"><?php echo form_error('dob'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Age" ?></label><small class="text-danger"> *</small>
                        <input id="age" name="age" placeholder="" type="text" class="form-control" value="<?php echo set_value('age', $student_data->age); ?>" readonly />
                        <span class="text-danger"><?php echo form_error('age'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('category'); ?></label>

                        <select id="category_id" name="category_id" class="form-control">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <?php
                            foreach ($categorylist as $class) {
                            ?>
                                <option value="<?php echo $class['id'] ?>" <?php
                                                                            if ($student_data->category_id == $class['id']) {
                                                                                echo "selected =selected";
                                                                            }
                                                                            ?>><?php echo $class['category'] ?></option>
                            <?php
                                $count++;
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('category_id'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('religion'); ?></label>
                        <input id="religion" name="religion" placeholder="" type="text" class="form-control" value="<?php echo set_value('religion', $student_data->religion); ?>" />
                        <span class="text-danger"><?php echo form_error('religion'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('cast'); ?></label>
                        <input id="cast" name="cast" placeholder="" type="text" class="form-control" value="<?php echo set_value('cast', $student_data->cast); ?>" />
                        <span class="text-danger"><?php echo form_error('cast'); ?></span>
                    </div>
                </div>





                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('mobile_no'); ?></label>
                        <input id="mobileno" name="mobileno" placeholder="" type="number" class="form-control" value="<?php echo set_value('mobileno', $student_data->mobileno); ?>" />
                        <span class="text-danger"><?php echo form_error('mobileno'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?></label>
                        <input id="email" name="email" placeholder="" type="email" class="form-control" value="<?php echo set_value('email', $student_data->email); ?>" />
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('fees_year'); ?></label><small class="text-danger"> *</small>
                        <select id="year" name="year" class="form-control">







                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <?php
                            foreach ($feeyearlist as $class) {
                            ?>
                                <option value="<?php echo $class['id'] ?>" <?php
                                                                            if ($student_data->year == $class['id']) {
                                                                                echo "selected =selected";
                                                                            }
                                                                            ?>><?php echo $class['year'] ?></option>
                            <?php
                                $count++;
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('year'); ?></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">

                        <label for="exampleInputEmail1"><?php echo $this->lang->line('admission_date'); ?></label>
                        <small class="text-danger"> *</small>
                        <input id="admission_date" name="admission_date" placeholder="" type="date" class="form-control" value="<?php echo set_value('admission_date', $student_data->admission_date); ?>" />
                        <span class="text-danger"><?php echo form_error('admission_date'); ?></span>



                    </div>
                </div>


            </div>
            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputFile"><?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('photo'); ?></label>
                        <div>
                            <?php if (!empty($student_data->file)) : ?>
                                <img src="<?php echo base_url('uploads/student_images/' . $student_data->file); ?>" class="img-thumbnail" alt="Student Photo" width="120" style="max-height: 120px;">
                            <?php endif; ?>
                            <input class="filestyle form-control" type='file' name='file' id="file" size='20' />
                        </div>
                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                    </div>
                </div>


                <div class="col-md-3 col-xs-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('blood_group'); ?></label>
                        <select class="form-control" name="blood_group">
                            <option value="">Select</option>
                            <option value="A+ve" <?php echo set_select('blood_group', 'A+ve', ($student_data->blood_group == 'A+ve')); ?>>A+ve</option>
                            <option value="B+ve" <?php echo set_select('blood_group', 'B+ve', ($student_data->blood_group == 'B+ve')); ?>>B+ve</option>
                            <option value="AB+ve" <?php echo set_select('blood_group', 'AB+ve', ($student_data->blood_group == 'AB+ve')); ?>>AB+ve</option>
                        </select>
                        <span class="text-danger"><?php echo form_error('blood_group'); ?></span>
                    </div>
                </div>

                <input type="hidden" name="file_name" value=<?php echo   $student_data->file ?>>
                <input type="hidden" name="father_file_name" value=<?php echo   $student_data->father_pic ?>>
                <input type="hidden" name="mother_file_name" value=<?php echo   $student_data->mother_pic ?>>
                <input type="hidden" name="guardian_file_name" value=<?php echo   $student_data->guardian_pic ?>>

                <div class="col-md-3 col-xs-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('height'); ?></label>
                        <?php


                        ?>
                        <input type="text" name="height" class="form-control" value="<?php echo set_value('height', $student_data->height); ?>">
                        <span class="text-danger"><?php echo form_error('height'); ?></span>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('weight'); ?></label>
                        <?php


                        ?>
                        <input type="text" name="weight" class="form-control" value="<?php echo set_value('weight', $student_data->weight); ?>">
                        <span class="text-danger"><?php echo form_error('weight'); ?></span>
                    </div>
                </div>




                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nationality</label>
                        <input id="nationality" name="nationality" placeholder="" type="text" class="form-control" value="<?php echo set_value('nationality', $student_data->nationality); ?>" />
                        <span class="text-danger"><?php
                                                    echo form_error('nationality');
                                                    ?></span>
                    </div>
                </div>



                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <?php echo $this->lang->line('annual_income'); ?>
                        </label><small class="text-danger"> </small>
                        <input id="annual_income" name="annual_income" placeholder="" type="text" class="form-control" value="<?php echo set_value('annual_income', $student_data->annual_income); ?>" />
                        <span class="text-danger"><?php echo form_error('annual_income'); ?></span>
                    </div>
                </div>




                <div class="col-md-3 col-xs-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <?php echo "Adhar No"; ?>
                        </label>
                        <input id="adhar_no" name="adhar_no" placeholder="" type="text" class="form-control" value="<?php echo set_value('adhar_no', $student_data->adhar_no); ?>" />
                        <span class="text-danger"><?php echo form_error('adhar_no'); ?></span>
                    </div>
                </div>
                <!-- <div class="col-md-3" style="display:none;">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('fees_discount'); ?></label>
                        <input id="fees_discount" name="fees_discount" placeholder="" type="text" class="form-control" value="<?php echo set_value('fees_discount', 0); ?>" />
                        <span class="text-danger"><?php echo form_error('fees_discount'); ?></span>
                    </div>
                </div> -->


            </div>


        </div>
        <div class="row bg-secondary rounded-top p-3">
            <div class="text-white p-2 text-center text-md-start">
                <span class="fw-bold "><?php echo $this->lang->line('parent_guardian_detail'); ?></span>
            </div>
        </div>
        <div class="row bg-light rounded-bottom shadow p-3 mb-4">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('father_name'); ?></label><small class="text-danger"> *</small>
                        <input id="father_name" name="father_name" placeholder="" type="text" class="form-control" value="<?php echo set_value('father_name', $student_data->father_name); ?>" />
                        <span class="text-danger"><?php echo form_error('father_name'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('father_phone'); ?></label><small class="text-danger"> *</small>
                        <input id="father_phone" name="father_phone" placeholder="" type="text" class="form-control" value="<?php echo set_value('father_phone', $student_data->father_phone); ?>" />
                        <span class="text-danger"><?php echo form_error('father_phone'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('father_occupation'); ?></label>
                        <input id="father_occupation" name="father_occupation" placeholder="" type="text" class="form-control" value="<?php echo set_value('father_occupation', $student_data->father_occupation); ?>" />
                        <span class="text-danger"><?php echo form_error('father_occupation'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- <div class="form-group">
                        <label for="exampleInputFile"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('photo'); ?></label>
                        <div><input class="filestyle form-control" type='file' name='father_pic' id="file" size='20' />
                        </div>
                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                    </div> -->
                    <div class="form-group">
                        <label for="exampleInputFile"><?php echo $this->lang->line('father'); ?> <?php echo $this->lang->line('photo'); ?></label>
                        <div>
                            <?php if (!empty($student_data->father_pic)) : ?>
                                <img src="<?php echo base_url('uploads/student_images/' . $student_data->father_pic); ?>" class="img-thumbnail" alt="father Photo" width="120" style="max-height: 120px;">
                            <?php endif; ?>
                            <input class="filestyle form-control" type='file' name='father_pic' id="father_file_name" size='20' />
                        </div>
                        <span class="text-danger"><?php echo form_error('father_file_name'); ?></span>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_name'); ?></label>
                        <input id="mother_name" name="mother_name" placeholder="" type="text" class="form-control" value="<?php echo set_value('mother_name', $student_data->mother_name); ?>" />
                        <span class="text-danger"><?php echo form_error('mother_name'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_phone'); ?></label>
                        <input id="mother_phone" name="mother_phone" placeholder="" type="text" class="form-control" value="<?php echo set_value('mother_phone', $student_data->mother_phone); ?>" />
                        <span class="text-danger"><?php echo form_error('mother_phone'); ?></span>
                    </div>


                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('mother_occupation'); ?></label>
                        <input id="mother_occupation" name="mother_occupation" placeholder="" type="text" class="form-control" value="<?php echo set_value('mother_occupation', $student_data->mother_occupation); ?>" />
                        <span class="text-danger"><?php echo form_error('mother_occupation'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- <div class="form-group">
                        <label for="exampleInputFile"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('photo'); ?></label>
                        <div><input class="filestyle form-control" type='file' name='mother_pic' id="file" size='20' />
                        </div>
                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                    </div>
                </div> -->
                <div class="form-group">
                        <label for="exampleInputFile"><?php echo $this->lang->line('mother'); ?> <?php echo $this->lang->line('photo'); ?></label>
                        <div>
                            <?php if (!empty($student_data->mother_pic)) : ?>
                                <img src="<?php echo base_url('uploads/student_images/' . $student_data->mother_pic); ?>" class="img-thumbnail" alt="mother Photo" width="120" style="max-height: 120px;">
                            <?php endif; ?>
                            <input class="filestyle form-control" type='file' name='mother_pic' id="file" size='20' />
                        </div>
                        <span class="text-danger"><?php echo form_error('mother_pic'); ?></span>
                    </div>
            </div>
           
            <div class="row">
                <div class="form-group col-md-12">
                    <label><?php echo $this->lang->line('if_guardian_is'); ?><small class="text-danger"> *</small>&nbsp;&nbsp;&nbsp;</label>
                    <label class="radio-inline">
                        <input type="radio" name="guardian_is" <?php echo ($student_data->guardian_is == "father") ? "checked" : ""; ?> value="father"> <?php echo $this->lang->line('father'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="guardian_is" <?php echo ($student_data->guardian_is == "mother") ? "checked" : ""; ?> value="mother"> <?php echo $this->lang->line('mother'); ?>
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="guardian_is" <?php echo ($student_data->guardian_is == "other") ? "checked" : ""; ?> value="other"> <?php echo $this->lang->line('other'); ?>
                    </label>
                    <span class="text-danger"><?php echo form_error('guardian_is'); ?></span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_name'); ?></label><small class="text-danger"> *</small>
                                <input id="guardian_name" name="guardian_name" placeholder="" type="text" class="form-control" value="<?php echo set_value('guardian_name', $student_data->guardian_name); ?>" />
                                <span class="text-danger"><?php echo form_error('guardian_name'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_relation'); ?></label>
                                <input id="guardian_relation" name="guardian_relation" placeholder="" type="text" class="form-control" value="<?php echo set_value('guardian_relation', $student_data->guardian_relation); ?>" />
                                <span class="text-danger"><?php echo form_error('guardian_relation'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_phone'); ?></label><small class="text-danger"> *</small>
                                <input id="guardian_phone" name="guardian_phone" placeholder="" type="text" class="form-control" value="<?php echo set_value('guardian_phone', $student_data->guardian_phone); ?>" />
                                <span class="text-danger"><?php echo form_error('guardian_phone'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_occupation'); ?></label>
                                <input id="guardian_occupation" name="guardian_occupation" placeholder="" type="text" class="form-control" value="<?php echo set_value('guardian_occupation', $student_data->guardian_occupation); ?>" />
                                <span class="text-danger"><?php echo form_error('guardian_occupation'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_email'); ?></label>
                        <input id="guardian_email" name="guardian_email" placeholder="" type="email" class="form-control" value="<?php echo set_value('guardian_email', $student_data->guardian_email); ?>" />
                        <span class="text-danger"><?php echo form_error('guardian_email'); ?></span>
                    </div>

                </div>
                <div class="col-md-3">
                    <!-- <div class="form-group">
                        <label for="exampleInputFile"><?php echo $this->lang->line('guardian'); ?> <?php echo $this->lang->line('photo'); ?></label>
                        <div><input class="filestyle form-control" type='file' name='guardian_pic' id="file" size='20' />
                        </div>
                        <span class="text-danger"><?php echo form_error('file'); ?></span>
                    </div> -->
                    <div class="form-group">
                        <label for="exampleInputFile"><?php echo $this->lang->line('guardian'); ?> <?php echo $this->lang->line('photo'); ?></label>
                        <div>
                            <?php if (!empty($student_data->guardian_pic)) : ?>
                                <img src="<?php echo base_url('uploads/student_images/' . $student_data->guardian_pic); ?>" class="img-thumbnail" alt="guardian Photo" width="120" style="max-height: 120px;">
                            <?php endif; ?>
                            <input class="filestyle form-control" type='file' name='guardian_pic' id="guardian_pic" size='20' />
                        </div>
                        <span class="text-danger"><?php echo form_error('guardian'); ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="exampleInputEmail1"><?php echo $this->lang->line('guardian_address'); ?></label>
                    <textarea id="guardian_address" name="guardian_address" placeholder="" class="form-control" rows="2"><?php echo set_value('guardian_address', $student_data->guardian_address); ?></textarea>
                    <span class="text-danger"><?php echo form_error('guardian_address'); ?></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="autofill_current_address" onclick="return auto_fill_guardian_address();">
                                <?php echo $this->lang->line('if_guardian_address_is_current_address'); ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('current_address'); ?></label>
                            <textarea id="current_address" name="current_address" placeholder="" class="form-control"><?php echo set_value('current_address'); ?><?php echo set_value('current_address', $student_data->current_address); ?></textarea>
                            <span class="text-danger"><?php echo form_error('current_address'); ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="autofill_address" onclick="return auto_fill_address();">
                                <?php echo $this->lang->line('if_permanent_address_is_current_address'); ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('permanent_address'); ?></label>
                            <textarea id="permanent_address" name="permanent_address" placeholder="" class="form-control"><?php echo set_value('permanent_address'); ?><?php echo set_value('permanent_address', $student_data->permanent_address); ?></textarea>
                            <span class="text-danger"><?php echo form_error('permanent_address'); ?></span>
                        </div>
                    </div>
                </div>

            </div>


        </div>
        <div class="row bg-secondary rounded-top p-3">
            <div class="text-white p-2 text-center text-md-start">
                <span class="fw-bold "><?php echo "12th Exam details"; ?></span>
            </div>
        </div>
        <div class="row bg-light rounded-bottom shadow p-3 mb-4">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Last Institution Attended" ?></label><small class="text-danger"> *</small>
                        <input id="previous_school" name="previous_school" placeholder="" type="text" class="form-control" value="<?php echo set_value('previous_school', $student_data->previous_school); ?>" />
                        <span class="text-danger"><?php echo form_error('previous_school'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Name of Qualifying Examination" ?></label><small class="text-danger"> *</small>
                        <input id="qualifying_exam" name="qualifying_exam" placeholder="" type="text" class="form-control" value="<?php echo set_value('qualifying_exam', $student_data->qualifying_exam); ?>" />
                        <span class="text-danger"><?php echo form_error('qualifying_exam'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Reg No" ?></label> <small class="text-danger"> *</small>
                        <input id="regno" name="regno" placeholder="" type="text" class="form-control" value="<?php echo set_value('regno', $student_data->regno); ?>" />
                        <span class="text-danger"><?php echo form_error('regno'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Month & Year" ?></label><small class="text-danger"> *</small>
                        <input id="monthyear" name="monthyear" placeholder="" type="text" class="form-control" value="<?php echo set_value('monthyear', $student_data->monthyear); ?>" />
                        <span class="text-danger"><?php echo form_error('monthyear'); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Total mark Scored" ?></label><small class="text-danger"> *</small>
                        <input id="total_mark" name="total_mark" placeholder="" type="number" class="form-control" value="<?php echo set_value('total_mark', $student_data->total_mark); ?>" />
                        <span class="text-danger"><?php echo form_error('total_mark'); ?></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Neet Rank" ?></label><small class="text-danger"> *</small>
                        <input id="neetrank" name="neetrank" placeholder="" type="text" class="form-control" value="<?php echo set_value('neetrank', $student_data->neetrank); ?>" />
                        <span class="text-danger"><?php echo form_error('neetrank'); ?></span>
                    </div>
                </div>




                <div class="col-md-12">

                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo "Subject"; ?></th>
                                <th><?php echo "Mark Obtained"; ?></th>
                                <th><?php echo "Maximum Mark"; ?></th>
                                <th><?php echo "%Mark"; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "Chemistry"; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="chem_markob" class="form-control" name="chem_markob" value="<?php echo set_value('chem_markob', $student_data->chem_markob); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="chem_maxmark" class="form-control" name="chem_maxmark" value="<?php echo set_value('chem_maxmark', $student_data->chem_maxmark); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="chem_per" class="form-control chem-percentage" name="chem_per" value="<?php echo set_value('chem_per', $student_data->chem_per); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "Physics"; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="phy_markob" class="form-control" name="phy_markob" value="<?php echo set_value('phy_markob', $student_data->phy_markob); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="phy_maxmark" class="form-control" name="phy_maxmark" value="<?php echo set_value('phy_maxmark', $student_data->phy_maxmark); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="phy_per" class="form-control" name="phy_per" value="<?php echo set_value('phy_per', $student_data->phy_per); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "Biology"; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="bio_markob" class="form-control" name="bio_markob" value="<?php echo set_value('bio_markob', $student_data->bio_markob); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="bio_maxmark" class="form-control" name="bio_maxmark" value="<?php echo set_value('bio_maxmark', $student_data->bio_maxmark); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="bio_per" class="form-control" name="bio_per" value="<?php echo set_value('bio_per', $student_data->bio_per); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "Total (physics, chemistry, biology)"; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="tot1" class="form-control" name="tot1" value="<?php echo set_value('tot1', $student_data->tot1); ?>" readonly />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="tot2" class="form-control" name="tot2" value="<?php echo set_value('tot2', $student_data->tot2); ?>" readonly />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="tot3" class="form-control" name="tot3" value="<?php echo set_value('tot3', $student_data->tot3); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "English"; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="eng_markob" class="form-control" name="eng_markob" value="<?php echo set_value('eng_markob', $student_data->eng_markob); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="eng_maxmark" class="form-control" name="eng_maxmark" value="<?php echo set_value('eng_maxmark', $student_data->eng_maxmark); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="eng_per" class="form-control eng-percentage" name="eng_per" value="<?php echo set_value('eng_per', $student_data->eng_per); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "Total"; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="total_markobtained" class="form-control" name="total_mark" value="<?php echo set_value('total_mark', $student_data->total_mark); ?>" readonly />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="total_maxmark" class="form-control" name="total_maxmark" value="<?php echo set_value('total_maxmark', $student_data->total_maxmark); ?>" readonly />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="total_per" class="form-control" name="total_per" value="<?php echo set_value('total_per', $student_data->total_per); ?>" />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="row bg-secondary rounded-top p-3">
            <div class="text-white p-2 text-center text-md-start">
                <span class="fw-bold "><?php echo "Details of qualifying details(MBBS)"; ?></span>
            </div>
        </div>
        <div class="row bg-light rounded-bottom shadow p-3 mb-4">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Name of college" ?></label><small class="text-danger"> *</small>
                        <input id="previous_school" name="med_previous_school" placeholder="" type="text" class="form-control" value="<?php echo set_value('previous_school', $student_data->previous_school); ?>" />
                        <span class="text-danger"><?php echo form_error('previous_school'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Name of Council" ?></label><small class="text-danger"> *</small>
                        <input id="qualifying_exam" name="med_qualifying_exam" placeholder="" type="text" class="form-control" value="<?php echo set_value('qualifying_exam', $student_data->qualifying_exam); ?>" />
                        <span class="text-danger"><?php echo form_error('qualifying_exam'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Reg No" ?></label> <small class="text-danger"> *</small>
                        <input id="regno" name="med_regno" placeholder="" type="text" class="form-control" value="<?php echo set_value('regno', $student_data->regno); ?>" />
                        <span class="text-danger"><?php echo form_error('regno'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Year" ?></label><small class="text-danger"> *</small>
                        <input id="monthyear" name="med_year" placeholder="" type="text" class="form-control" value="<?php echo set_value('monthyear', $student_data->monthyear); ?>" />
                        <span class="text-danger"><?php echo form_error('monthyear'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Distinction/first class/second class" ?></label><small class="text-danger"> *</small>
                        <input id="dfs" name="dfs" placeholder="" type="text" class="form-control" value="<?php echo set_value('dfs', $student_data->dfs); ?>" />
                        <span class="text-danger"><?php echo form_error('dfs'); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">


                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo "Subject" ?></th>
                                <th><?php echo "Mark Awarded" ?></th>
                                <th><?php echo "Maximum Marks" ?></th>
                                <th><?php echo "%Mark" ?></th>
                                <th><?php echo "Year" ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "12th Exam details" ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="first_mbbs_scored" class="form-control" name="first_mbbs_scored" value="<?php echo set_value('table_data[' . $i . '][column2]', $student_data->first_mbbs_scored); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="first_mbbs_max" class="form-control" name="first_mbbs_max" value="<?php echo set_value('table_data[' . $i . '][column3]', $student_data->first_mbbs_max); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="first_mbbs_per" class="form-control chem-percentage" name="first_mbbs_per" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->first_mbbs_per); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="first_mbbs_year" class="form-control chem-percentage" name="first_mbbs_year" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->first_mbbs_year); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "2nd Year MBBS" ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="second_mbbs_scored" class="form-control" name="second_mbbs_scored" value="<?php echo set_value('table_data[' . $i . '][column2]', $student_data->second_mbbs_scored); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="second_mbbs_max" class="form-control" name="second_mbbs_max" value="<?php echo set_value('table_data[' . $i . '][column3]', $student_data->second_mbbs_max); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="second_mbbs_per" class="form-control" name="second_mbbs_per" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->second_mbbs_per); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="second_mbbs_year" class="form-control" name="second_mbbs_year" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->second_mbbs_year); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "3rd Year MBBS (Part 1)" ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="third_mbbs_scored" class="form-control" name="third_mbbs_scored" value="<?php echo set_value('table_data[' . $i . '][column2]', $student_data->third_mbbs_scored); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="third_mbbs_max" class="form-control" name="third_mbbs_max" value="<?php echo set_value('table_data[' . $i . '][column3]', $student_data->third_mbbs_max); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="third_mbbs_per" class="form-control" name="third_mbbs_per" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->third_mbbs_per); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="third_mbbs_year" class="form-control" name="third_mbbs_year" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->third_mbbs_year); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "3rd Year MBBS (Part 2)" ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="third_mbbs_scored2" class="form-control" name="third_mbbs_scored2" value="<?php echo set_value('table_data[' . $i . '][column2]', $student_data->third_mbbs_scored2); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="third_mbbs_max2" class="form-control" name="third_mbbs_max2" value="<?php echo set_value('table_data[' . $i . '][column3]', $student_data->third_mbbs_max2); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="third_mbbs_per2" class="form-control" name="third_mbbs_per2" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->third_mbbs_per2); ?>" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="third_mbbs_year2" class="form-control" name="third_mbbs_year2" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->third_mbbs_year2); ?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "Total" ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="med_total" class="form-control" name="med_total" value="<?php echo set_value('table_data[' . $i . '][column2]', $student_data->med_total); ?>" readonly />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="med_total_max" class="form-control" name="med_total_max" value="<?php echo set_value('table_data[' . $i . '][column3]', $student_data->med_total_max); ?>" readonly />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="med_total_per" class="form-control eng-percentage" name="med_total_per" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->med_total_per); ?>" readonly />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="med_total_year" class="form-control eng-percentage" name="med_total_year" value="<?php echo set_value('table_data[' . $i . '][column4]', $student_data->med_total_year); ?>" readonly />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="row bg-secondary rounded-top p-3">
            <div class="text-white p-2 text-center text-md-start">
                <span class="fw-bold "><?php echo "NEET DETAILS"; ?></span>
            </div>
        </div>
        <div class="row bg-light rounded-bottom shadow p-3 mb-4">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Neet Registration Number" ?></label><small class="text-danger"> *</small>
                        <input id="neet_reg" name="neet_reg" placeholder="" type="text" class="form-control" value="<?php echo set_value('neet_reg', $student_data->neet_reg); ?>" />
                        <span class="text-danger"><?php echo form_error('neet_reg'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Neet Rank" ?></label><small class="text-danger"> *</small>
                        <input id="neet_rank" name="neet_rank" placeholder="" type="text" class="form-control" value="<?php echo set_value('neet_rank', $student_data->neet_rank); ?>" />
                        <span class="text-danger"><?php echo form_error('neet_rank'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Neet Marks" ?></label> <small class="text-danger"> *</small>
                        <input id="neet_marks" name="neet_marks" placeholder="" type="text" class="form-control" value="<?php echo set_value('neet_marks', $student_data->neet_marks); ?>" />
                        <span class="text-danger"><?php echo form_error('neet_marks'); ?></span>
                    </div>
                </div>


            </div>
            <div class="row">

                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo "Subject" ?></th>
                                <th><?php echo "Mark Awarded" ?></th>



                            </tr>
                        </thead>
                        <tbody>



                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "Physics" ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="neet_phy_mark_obtained" class="form-control" name="neet_phy_mark_obtained" value="<?php echo set_value('table_data[' . $i . '][column2]', $student_data->neet_phy_mark_obtained); ?>" />
                                    </div>
                                </td>


                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <?php echo "Chemistry" ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="neet_chem_mark_obtained" class="form-control" name="neet_chem_mark_obtained" value="<?php echo set_value('table_data[' . $i . '][column2]', $student_data->neet_chem_mark_obtained); ?>" />
                                    </div>
                                </td>


                            </tr>
                            <tr>

                                <td>
                                    <div class="form-group">
                                        <?php echo "Biology" ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="neet_bio_mark_biology" class="form-control" name="neet_bio_mark_biology" value="<?php echo set_value('table_data[' . $i . '][column2]', $student_data->neet_bio_mark_biology); ?>" />
                                    </div>
                                </td>


                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <?php echo "NEET Percentile" ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" id="neet_percentile" class="form-control" name="neet_percentile" value="<?php echo set_value('table_data[' . $i . '][column2]', $student_data->med_total_per); ?>" />
                                    </div>
                                </td>


                            </tr>



                        </tbody>
                    </table>

                </div>
            </div>


        </div>
        <div class="row bg-secondary rounded-top p-3">
            <div class="text-white p-2 text-center text-md-start">
                <span class="fw-bold "><?php echo "KEAM DETAILS"; ?></span>
            </div>
        </div>
        <div class="row bg-light rounded-bottom shadow p-3 mb-4">

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Keam Roll Number" ?></label><small class="text-danger"> *</small>
                        <input id="keam_roll_no" name="keam_roll_no" placeholder="" type="text" class="form-control" value="<?php echo set_value('keam_roll_no', $student_data->keam_roll_no); ?>" />
                        <span class="text-danger"><?php echo form_error('keam_roll_no'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Kerala Medical Rank" ?></label><small class="text-danger"> *</small>
                        <input id="kerala_medical_rank" name="kerala_medical_rank" placeholder="" type="text" class="form-control" value="<?php echo set_value('kerala_medical_rank', $student_data->kerala_medical_rank); ?>" />
                        <span class="text-danger"><?php echo form_error('kerala_medical_rank'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo "Seat Type AIQ/Open merit/NRI" ?></label> <small class="text-danger"> *</small>
                        <input id="seat_type" name="seat_type" placeholder="" type="text" class="form-control" value="<?php echo set_value('seat_type', $student_data->seat_type); ?>" />
                        <span class="text-danger"><?php echo form_error('seat_type'); ?></span>
                    </div>
                </div>


            </div>


        </div>
        <div class="row bg-secondary rounded-top p-3">
            <div class="text-white p-2 text-center text-md-start">
                <span class="fw-bold "><?php echo "BANK ACCOUNT DETAILS"; ?></span>
            </div>
        </div>
        <div class="row bg-light rounded-bottom shadow p-3 mb-4">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('bank_account_no'); ?></label>
                        <input id="bank_account_no" name="bank_account_no" placeholder="" type="text" class="form-control" value="<?php echo set_value('bank_account_no', $student_data->bank_account_no); ?>" />
                        <span class="text-danger"><?php echo form_error('bank_account_no'); ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('bank_name'); ?></label>
                        <input id="bank_name" name="bank_name" placeholder="" type="text" class="form-control" value="<?php echo set_value('bank_name', $student_data->bank_name); ?>" />
                        <span class="text-danger"><?php echo form_error('bank_name'); ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('ifsc_code'); ?></label>
                        <input id="ifsc_code" name="ifsc_code" placeholder="" type="text" class="form-control" value="<?php echo set_value('ifsc_code', $student_data->ifsc_code); ?>" />
                        <span class="text-danger"><?php echo form_error('ifsc_code'); ?></span>
                    </div>
                </div>
            </div>

            <div class="row around10">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1">
                            <?php echo $this->lang->line('local_identification_no'); ?>
                        </label>
                        <input id="samagra_id" name="samagra_id" placeholder="" type="text" class="form-control" value="<?php echo set_value('samagra_id', $student_data->samagra_id); ?>" />
                        <span class="text-danger"><?php echo form_error('samagra_id'); ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label><?php echo $this->lang->line('rte'); ?></label>
                    <div class="radio" style="margin-top: 2px;">
                        <label><input class="radio-inline" type="radio" name="rte" value="Yes" <?php
                                                                                                echo set_value('rte') == "yes" ? "checked" : "";
                                                                                                ?>><?php echo $this->lang->line('yes'); ?></label>
                        <label><input class="radio-inline" checked="checked" type="radio" name="rte" value="No" <?php
                                                                                                                echo set_value('rte') == "no" ? "checked" : "";
                                                                                                                ?>><?php echo $this->lang->line('no'); ?></label>
                    </div>
                    <span class="text-danger"><?php echo form_error('rte'); ?></span>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('previous_school_details'); ?></label>
                        <textarea class="form-control" rows="3" placeholder="" name="previous_school"><?php echo set_value('previous_school', $student_data->previous_school); ?></textarea>
                        <span class="text-danger"><?php echo form_error('previous_school'); ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('note'); ?></label>
                        <textarea class="form-control" rows="3" placeholder="" name="note"><?php echo set_value('note', $student_data->note); ?></textarea>
                        <span class="text-danger"><?php echo form_error('note'); ?></span>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('scholarship'); ?></label>
                        <select id="scholarship" name="scholarship" class="form-control">



                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <?php
                            foreach ($sch as $key => $value) {
                            ?>
                                <option value="<?php echo $key; ?>" <?php if ($student_data->scholarship == $key) echo "selected"; ?>><?php echo $value; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('scholarship'); ?></span>
                    </div>
                </div>






            </div>

        </div>
        <div class="box-footer ">
            <button type="submit" class="btn btn-info text-right"><?php echo $this->lang->line('save'); ?></button>
        </div>


</div>

</form>
</div>
<!-- <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" /> -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script> -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<script type="text/javascript">
    function getSectionByClass(class_id, section_id) {
        if (class_id != "" && section_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "TemporaryUser/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        }
    }

    $(document).ready(function() {




        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);

        $(document).on('change', '#class_id', function(e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            // if (class_id == '5') {

            //     document.getElementById('plustwo').style.display = 'block';
            //     document.getElementById('medical').style.display = 'none';
            // } else if (class_id == '9' || class_id == '10')

            // {
            //     document.getElementById('plustwo').style.display = 'none';
            //     document.getElementById('medical').style.display = 'block';
            // } else

            // {
            //     document.getElementById('medical').style.display = 'none';
            //     document.getElementById('plustwo').style.display = 'none';
            // }
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "temporary_user/TemporaryUser/getByClass",
                data: {
                    'class_id': class_id
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        });


        $(function() {
            $('#dob,#admission_date,#measure_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true
            });
        });

    });
</script>

<script>
    function calculateAge() {
        var dob = document.getElementById("dob").value;
        if (dob) {
            var dobDate = new Date(dob);
            var today = new Date();
            var age = today.getFullYear() - dobDate.getFullYear();
            var monthDifference = today.getMonth() - dobDate.getMonth();
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dobDate.getDate())) {
                age--;
            }
            document.getElementById("age").value = age;
        } else {
            document.getElementById("age").value = "";
        }
    }
</script>

<script>
    // Function to calculate the totals for Chemistry, Physics, and Biology
    function calculateSubTotals() {
        var chemMarkOb = parseFloat(document.getElementById('chem_markob').value) || 0;
        var phyMarkOb = parseFloat(document.getElementById('phy_markob').value) || 0;
        var bioMarkOb = parseFloat(document.getElementById('bio_markob').value) || 0;
        var engMarkOb = parseFloat(document.getElementById('eng_markob').value) || 0;

        var chemMaxMark = parseFloat(document.getElementById('chem_maxmark').value) || 1; // Default to 1 to avoid division by zero
        var phyMaxMark = parseFloat(document.getElementById('phy_maxmark').value) || 1; // Default to 1 to avoid division by zero
        var bioMaxMark = parseFloat(document.getElementById('bio_maxmark').value) || 1; // Default to 1 to avoid division by zero
        var engMaxMark = parseFloat(document.getElementById('eng_maxmark').value) || 1;

        var tot1 = chemMarkOb + phyMarkOb + bioMarkOb;
        var tot2 = chemMaxMark + phyMaxMark + bioMaxMark;

        document.getElementById('tot1').value = tot1;
        document.getElementById('tot2').value = tot2;

        // Calculate percentages
        var chemPer = (chemMarkOb / chemMaxMark) * 100;
        var phyPer = (phyMarkOb / phyMaxMark) * 100;
        var bioPer = (bioMarkOb / bioMaxMark) * 100;
        var eng_per = (engMarkOb / engMaxMark) * 100;
        var tot3 = (tot1 / tot2) * 100;


        document.getElementById('chem_per').value = chemPer.toFixed(2);
        document.getElementById('phy_per').value = phyPer.toFixed(2);
        document.getElementById('bio_per').value = bioPer.toFixed(2);
        document.getElementById('eng_per').value = eng_per.toFixed(2);
        document.getElementById('tot3').value = tot3.toFixed(2);


        calculateFinalTotal();
    }

    // Function to calculate the final totals including English
    function calculateFinalTotal() {
        var tot1 = parseFloat(document.getElementById('tot1').value) || 0;
        var tot2 = parseFloat(document.getElementById('tot2').value) || 0;

        var engMarkOb = parseFloat(document.getElementById('eng_markob').value) || 0;
        var engMaxMark = parseFloat(document.getElementById('eng_maxmark').value) || 0;

        var totalMark = engMarkOb + tot1;


        var totalMaxMark = engMaxMark + tot2;


        document.getElementById('total_markobtained').value = totalMark;
        document.getElementById('total_maxmark').value = totalMaxMark;

        var totalPer = (totalMark / totalMaxMark) * 100;
        document.getElementById('total_per').value = totalPer.toFixed(2);
    }

    // Add event listeners to the input fields
    document.addEventListener('DOMContentLoaded', function() {
        var inputs = ['chem_markob', 'phy_markob', 'bio_markob', 'chem_maxmark', 'phy_maxmark', 'bio_maxmark', 'eng_markob', 'eng_maxmark'];

        inputs.forEach(function(id) {
            document.getElementById(id).addEventListener('input', calculateSubTotals);
        });
    });
</script>



<script>
    function calculateNeetTotals() {
        var neet_phy_mark_obtained = parseFloat(document.getElementById('neet_phy_mark_obtained').value) || 0;
        var neet_chem_mark_obtained = parseFloat(document.getElementById('neet_chem_mark_obtained').value) || 0;
        var neet_bio_mark_biology = parseFloat(document.getElementById('neet_bio_mark_biology').value) || 0;

        var neet_total = neet_phy_mark_obtained + neet_chem_mark_obtained + neet_bio_mark_biology;
        var neet_percentile = (neet_total / 720) * 100;


        document.getElementById('neet_percentile').value = neet_percentile.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function() {
        var inputs = ['neet_phy_mark_obtained', 'neet_chem_mark_obtained', 'neet_bio_mark_biology'];

        inputs.forEach(function(id) {
            document.getElementById(id).addEventListener('input', calculateNeetTotals);
        });
    });
</script>



<script>
    function calculateOrgTotals() {
        var first_mbbs_scored = parseFloat(document.getElementById('first_mbbs_scored').value) || 0;
        var second_mbbs_scored = parseFloat(document.getElementById('second_mbbs_scored').value) || 0;
        var third_mbbs_scored = parseFloat(document.getElementById('third_mbbs_scored').value) || 0;
        var third_mbbs_scored2 = parseFloat(document.getElementById('third_mbbs_scored2').value) || 0;

        var first_mbbs_max = parseFloat(document.getElementById('first_mbbs_max').value) || 0;
        var second_mbbs_max = parseFloat(document.getElementById('second_mbbs_max').value) || 0;
        var third_mbbs_max = parseFloat(document.getElementById('third_mbbs_max').value) || 0;
        var third_mbbs_max2 = parseFloat(document.getElementById('third_mbbs_max2').value) || 0;

        var first_mbbs_year = parseFloat(document.getElementById('first_mbbs_year').value) || 0;
        var second_mbbs_year = parseFloat(document.getElementById('second_mbbs_year').value) || 0;
        var third_mbbs_year = parseFloat(document.getElementById('third_mbbs_year').value) || 0;
        var third_mbbs_year2 = parseFloat(document.getElementById('third_mbbs_year2').value) || 0;

        var med_total = first_mbbs_scored + second_mbbs_scored + third_mbbs_scored + third_mbbs_scored2;
        var med_total_max = first_mbbs_max + second_mbbs_max + third_mbbs_max + third_mbbs_max2;
        var med_total_year = first_mbbs_year + second_mbbs_year + third_mbbs_year + third_mbbs_year2;

        document.getElementById('med_total').setAttribute('value', med_total);
        document.getElementById('med_total_max').value = med_total_max;
        document.getElementById('med_total_year').value = med_total_year;

        var first_mbbs_per = (first_mbbs_scored / first_mbbs_max) * 100 || 0;
        var second_mbbs_per = (second_mbbs_scored / second_mbbs_max) * 100 || 0;
        var third_mbbs_per = (third_mbbs_scored / third_mbbs_max) * 100 || 0;
        var third_mbbs_per2 = (third_mbbs_scored2 / third_mbbs_max2) * 100 || 0;
        var med_total_per = (med_total / med_total_max) * 100 || 0;

        document.getElementById('first_mbbs_per').value = first_mbbs_per.toFixed(2);
        document.getElementById('second_mbbs_per').value = second_mbbs_per.toFixed(2);
        document.getElementById('third_mbbs_per').value = third_mbbs_per.toFixed(2);
        document.getElementById('third_mbbs_per2').value = third_mbbs_per2.toFixed(2);
        document.getElementById('med_total_per').value = med_total_per.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function() {
        var inputs = ['first_mbbs_scored', 'second_mbbs_scored', 'third_mbbs_scored', 'third_mbbs_scored2',
            'first_mbbs_max', 'second_mbbs_max', 'third_mbbs_max', 'third_mbbs_max2',
            'first_mbbs_year', 'second_mbbs_year', 'third_mbbs_year', 'third_mbbs_year2'
        ];

        inputs.forEach(function(id) {
            document.getElementById(id).addEventListener('input', calculateOrgTotals);
        });
    });
</script>