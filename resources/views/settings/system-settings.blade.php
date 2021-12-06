@extends('layouts.dashboard')
@section('content')


    <div class="container main-content">
        <div class="row col-md-12 no-padding">
            <div id="sidebar-menu" class="col-md-2">
                <ul class="nav navbar-nav">
                    @include('layouts.get-user-menu')
                </ul>
            </div>
            <div id="right-content" class="col-md-10">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-12 col-xl-12">
                        <div class="col-12" style="padding:20px 0;padding-bottom: 0;">
                            <div class="form-group">
                                <div class="btn-group" role="group" aria-label="Modules">
                                    <button id="system_settings" type="button"
                                            class="btn btn-outline-secondary btn-group-item active ">System Settings
                                    </button>
                                    <button id="dashboard_settings" type="button"
                                            class="btn btn-outline-secondary btn-group-item ">Dashboard Settings
                                    </button>
                                    <button id="points" type="button" class="btn btn-outline-secondary btn-group-item">
                                        Points
                                    </button>
                                    <button id="permissions" type="button"
                                            class="btn btn-outline-secondary btn-group-item">Permissions
                                    </button>
                                    <button id="task_settings" type="button"
                                            class="btn btn-outline-secondary btn-group-item">Task Settings
                                    </button>
                                    <button id="donation_request_settings" type="button"
                                            class="btn btn-outline-secondary btn-group-item">Donation Request Settings
                                    </button>
                                </div>
                                <hr style="margin-top:10px;"/>
                            </div>
                        </div>

                        <?php
                        //Settings
                        if(request()->segment(2) === 'system-settings'){
                        ?>
                        <div class="col-6">
                            <h4>System Settings</h4>
                        </div>
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <div class="app_notifications label label-success" id="success-alert">
                            <h3>Tutor added Successfully</h3>
                        </div>
                    <form id="system_settings_form" action="{{url('/settings/system-settings/')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="col-md-12 settings_card">
                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Show Student Details Form:</label>
                                </div>
                                <div class="col-md-7">
                                    <select id="show_student_details_form" name="show_student_details_form"
                                            class="form-control lb-lg">
                                        <option value="1" {{(($show_student_details_form == '1')? print 'selected=""': print "")}}>Yes</option>
                                        <option value="0" {{(($show_student_details_form == '0')? print 'selected=""': print "")}}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>System From Email:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="system_from_email" name="system_from_email" type="text"
                                           class="form-control lb-lg" value="{{$system_from_email}}"/>
                                </div>
                            </div>
                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Instalment Email Notification:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="installment_email_notification" name="installment_email_notification"
                                           type="text" class="form-control lb-lg" value="{{$installment_email_notification}}"/>
                                </div>
                            </div>
                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Turn Discount Student:</label>
                                </div>
                                <div class="col-md-7">
                                    <select id="turn_discount_student" name="turn_discount_student"
                                            class="form-control lb-lg">
                                        <option value="1" {{(($turn_discount_student == '1')? print 'selected=""': print "")}}>ON</option>
                                        <option value="0" {{(($turn_discount_student == '0')? print 'selected=""': print "")}}>OFF</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Payment Type:</label>
                                </div>
                                <div class="col-md-7">
                                    <select id="payment_type" name="payment_type" class="form-control lb-lg">
                                        <option value="paypal" {{(($payment_type === 'paypal')? print 'selected=""': print "")}}>Paypal</option>
                                        <option value="sagepay" {{(($payment_type === 'sagepay')? print 'selected=""': print "")}}>Sagepay</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Turn IV:</label>
                                </div>
                                <div class="col-md-7">
                                    <select id="turn_iv" name="turn_iv" class="form-control lb-lg">
                                        <option value="1" {{(($turn_iv == 1)? print 'selected=""': print "")}}>On</option>
                                        <option value="0" {{(($turn_iv == 0)? print 'selected=""': print "")}}>Off</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Home Page User Guide Link:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="home_page_user_guide_link" name="home_page_user_guide_link" type="text"
                                           class="form-control lb-lg" value="{{$home_page_user_guide_link}}"/>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Home Page Support Link:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="home_page_support_link" name="home_page_support_link" type="text"
                                           class="form-control lb-lg" value="{{$home_page_support_link}}"/>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Footer Text:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="footer_text" name="footer_text" type="text" class="form-control lb-lg"
                                           value="{{$footer_text}}"/>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>FAQ Link:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="faq_link" name="faq_link" type="text" class="form-control lb-lg"
                                           value="{{$faq_link}}"/>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Local FAQ Link:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="local_faq_link" name="local_faq_link" type="text"
                                           class="form-control lb-lg" value="{{$local_faq_link}}"/>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Feedback Email:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="feedback_email" name="feedback_email" type="text"
                                           class="form-control lb-lg" value="{{$feedback_email}}"/>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Read Email:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="read_email" name="read_email" type="text" class="form-control lb-lg"
                                           value="{{$read_email}}"/>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Days Until an Assignment is overdue for marking:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="overdue_assignment_duration" name="overdue_assignment_duration"
                                           type="number" class="form-control lb-lg" value="{{($overdue_assignment_duration)? $overdue_assignment_duration: print ""}}"/>
                                    <small id="overdue_assignment_duration_errors"></small>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Priority Students must be marked within (days):</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="priority_students_marking_duration" placeholder="Days"
                                           name="priority_students_marking_duration" type="number"
                                           class="form-control lb-lg" value="{{($priority_students_marking_duration)? $priority_students_marking_duration: print ""}}"/>
                                    <small id="priority_students_marking_duration_errors"></small>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Evidence Types:</label>
                                </div>
                                <div class="col-md-7">
                                    <textarea id="evidence_types" name="evidence_types" class="form-control lb-lg"
                                              >{{$evidence_types}}</textarea>
                                    <label>Use comma for separation (eg: type1,type2)</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr/>
                                <input type="button" id="save_settings" class="save_settings btn btn-primary" value="Save Settings"/>
                            </div>

                            <div class="col-md-12">
                                <br>
                                <hr/>
                                <br>
                                <h4>Company Profile</h4>
                                <hr/>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Company Name:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="company_name" name="company_name" type="text"
                                               class="form-control lb-lg" value="{{$company_name}}"/>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding" style="padding-bottom: 8px !important">
                                    <div class="col-md-5 no-padding">
                                        <label>Company Mailing Address:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <textarea rows="5" id="company_mailing_address" name="company_mailing_address"
                                                  class="form-control lb-lg" value="">{{$company_mailing_address}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding" style="padding-bottom: 8px !important">
                                    <div class="col-md-5 no-padding">
                                        <label>Company Physical / Registered Address:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <textarea rows="5" id="company_physical_address" name="company_physical_address"
                                                  class="form-control lb-lg" value="">{{$company_physical_address}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Company Number:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="company_number" name="company_number" type="number"
                                               class="form-control lb-lg" value="{{$company_number}}"/>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Company Website:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="company_website" name="company_website" type="text"
                                               class="form-control lb-lg" value="{{$company_website}}"/>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Phone Number:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="company_phone" name="company_phone" type="text"
                                               class="form-control lb-lg" value="{{$company_phone}}"/>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>VAT / TAX Percentage:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="vat_tax_percentage" name="vat_tax_percentage" type="number"
                                               class="form-control lb-lg" value="{{$vat_tax_percentage}}"/>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>VAT Number:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="vat_number" name="vat_number" type="number"
                                               class="form-control lb-lg" value="{{$vat_number}}"/>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Flat Rate Postage:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="flat_rate_postage" name="flat_rate_postage" type="text"
                                               class="form-control lb-lg" value="{{$flat_rate_postage}}"/>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Payment Details / Thank you message:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="thank_you_message" name="thank_you_message" type="text"
                                               class="form-control lb-lg" value="{{$thank_you_message}}"/>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Number of Installments:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select id="number_of_installments" name="number_of_installments"
                                                class="form-control lb-lg">
                                            <option value="1" {{(($number_of_installments == 1)? print 'selected=""': print "")}}>1</option>
                                            <option value="2" {{(($number_of_installments == 2)? print 'selected=""': print "")}}>2</option>
                                            <option value="3" {{(($number_of_installments == 3)? print 'selected=""': print "")}}>3</option>
                                            <option value="4" {{(($number_of_installments == 4)? print 'selected=""': print "")}}>4</option>
                                            <option value="5" {{(($number_of_installments == 5)? print 'selected=""': print "")}}>5</option>
                                            <option value="6" {{(($number_of_installments == 6)? print 'selected=""': print "")}}>6</option>
                                            <option value="7" {{(($number_of_installments == 7)? print 'selected=""': print "")}}>7</option>
                                            <option value="8" {{(($number_of_installments == 8)? print 'selected=""': print "")}}>8</option>
                                            <option value="9" {{(($number_of_installments == 9)? print 'selected=""': print "")}}>9</option>
                                            <option value="10" {{(($number_of_installments == 10)? print 'selected=""': print "")}}>10</option>
                                            <option value="11" {{(($number_of_installments == 11)? print 'selected=""': print "")}}>11</option>
                                            <option value="12" {{(($number_of_installments == 12)? print 'selected=""': print "")}}>12</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding" style="padding-bottom: 8px !important">
                                    <div class="col-md-5 no-padding">
                                        <label>Welcome Letter Content:
                                            <br>{username}, {password}, {firstname}, {lastname}</label>
                                    </div>
                                    <div class="col-md-7">
                                        <textarea id="welcome_letter_content" rows="15" name="welcome_letter_content"
                                                  class="form-control lb-lg" value="">{{$welcome_letter_content}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding" style="padding-bottom: 8px !important">
                                    <div class="col-md-5 no-padding">
                                        <label>Reseller Welcome Letter Content:
                                            <br>{username}, {password}, {firstname}, {lastname}</label>
                                    </div>
                                    <div class="col-md-7">
                                        <textarea id="reseller_welcome_letter_content" rows="15"
                                                  name="reseller_welcome_letter_content" class="form-control lb-lg"
                                                  value="">{{$reseller_welcome_letter_content}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <br>
                                    <div class="col-md-3 no-padding">
                                        <label>Send Welcome Letter:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="send_welcome_letter" name="send_welcome_letter"
                                                class="form-control lb-lg">
                                            <option value="1" {{(($send_welcome_letter == '1')? print 'selected=""': print "")}}>Yes</option>
                                            <option value="0" {{(($send_welcome_letter == '0')? print 'selected=""': print "")}}>No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 no-padding">
                                        <label>Send Certificate:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="send_certificate" name="send_certificate"
                                                class="form-control lb-lg">
                                            <option value="1" {{(($send_certificate == '1')? print 'selected=""': print "")}}>Yes</option>
                                            <option value="0" {{(($send_certificate == '0')? print 'selected=""': print "")}}>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-3 no-padding">
                                        <label>Date Format:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="date_format" name="date_format" class="form-control lb-lg">
                                            <option value="dd/mm/yy" {{(($date_format == 'dd/mm/yy')? print 'selected=""': print "")}}>dd/mm/yy</option>
                                            <option value="dd.mm.yy" {{(($date_format == 'dd.mm.yy')? print 'selected=""': print "")}}>dd.mm.yy</option>
                                            <option value="mm/dd/yy" {{(($date_format == 'mm/dd/yy')? print 'selected=""': print "")}}>mm/dd/yy</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 no-padding">
                                        <label>Price Format:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="price_format" name="price_format" class="form-control lb-lg">
                                            <option value="">Select Format</option>
                                            <option value="pound" {{(($price_format == 'pound')? print 'selected=""': print "")}}>₤</option>
                                            <option value="euro" {{(($price_format == 'euro')? print 'selected=""': print "")}}>€</option>
                                            <option value="dollar" {{(($price_format == 'dollar')? print 'selected=""': print "")}}>$</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 no-padding">
                                    <div class="col-md-3 no-padding">
                                        <label>Timezone:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="timezone" name="timezone" class="form-control lb-lg">
                                                <option value="">Select Timezone</option>
                                                <option value="1" {{(($timezone == 1)? print 'selected=""': print "")}}>International Date Line West (GMT-12:00)</option>
                                                <option value="2" {{(($timezone == 2)? print 'selected=""': print "")}}>Midway Island (GMT-11:00)</option>
                                                <option value="3" {{(($timezone == 3)? print 'selected=""': print "")}}>Samoa (GMT-11:00)</option>
                                                <option value="4" {{(($timezone == 4)? print 'selected=""': print "")}}>Hawaii (GMT-10:00)</option>
                                                <option value="5" {{(($timezone == 5)? print 'selected=""': print "")}}>Alaska (GMT-09:00)</option>
                                                <option value="6" {{(($timezone == 6)? print 'selected=""': print "")}}>Pacific Time (US &amp; Canada) (GMT-08:00)</option>
                                                <option value="7" {{(($timezone == 7)? print 'selected=""': print "")}}>Tijuana (GMT-08:00)</option>
                                                <option value="8" {{(($timezone == 8)? print 'selected=""': print "")}}>Arizona (GMT-07:00)</option>
                                                <option value="9" {{(($timezone == 9)? print 'selected=""': print "")}}>Mountain Time (US &amp; Canada) (GMT-07:00)</option>
                                                <option value="10" {{(($timezone == 10)? print 'selected=""': print "")}}>Chihuahua (GMT-07:00)</option>
                                                <option value="11" {{(($timezone == 11)? print 'selected=""': print "")}}>La Paz (GMT-07:00)</option>
                                                <option value="12" {{(($timezone == 12)? print 'selected=""': print "")}}>Mazatlan (GMT-07:00)</option>
                                                <option value="13" {{(($timezone == 13)? print 'selected=""': print "")}}>Central Time (US &amp; Canada) (GMT-06:00)</option>
                                                <option value="14" {{(($timezone == 14)? print 'selected=""': print "")}}>Central America (GMT-06:00)</option>
                                                <option value="15" {{(($timezone == 15)? print 'selected=""': print "")}}>Guadalajara (GMT-06:00)</option>
                                                <option value="16" {{(($timezone == 16)? print 'selected=""': print "")}}>Mexico City (GMT-06:00)</option>
                                                <option value="17" {{(($timezone == 17)? print 'selected=""': print "")}}>Monterrey (GMT-06:00)</option>
                                                <option value="18" {{(($timezone == 18)? print 'selected=""': print "")}}>Saskatchewan (GMT-06:00)</option>
                                                <option value="19" {{(($timezone == 19)? print 'selected=""': print "")}}>Eastern Time (US &amp; Canada) (GMT-05:00)</option>
                                                <option value="20" {{(($timezone == 20)? print 'selected=""': print "")}}>Indiana (East) (GMT-05:00)</option>
                                                <option value="21" {{(($timezone == 21)? print 'selected=""': print "")}}>Bogota (GMT-05:00)</option>
                                                <option value="22" {{(($timezone == 22)? print 'selected=""': print "")}}>Lima (GMT-05:00)</option>
                                                <option value="23" {{(($timezone == 23)? print 'selected=""': print "")}}>Quito (GMT-05:00)</option>
                                                <option value="24" {{(($timezone == 24)? print 'selected=""': print "")}}>Atlantic Time (Canada) (GMT-04:00)</option>
                                                <option value="25" {{(($timezone == 25)? print 'selected=""': print "")}}>Caracas (GMT-04:00)</option>
                                                <option value="26" {{(($timezone == 26)? print 'selected=""': print "")}}>La Paz (GMT-04:00)</option>
                                                <option value="27" {{(($timezone == 27)? print 'selected=""': print "")}}>Santiago (GMT-04:00)</option>
                                                <option value="28" {{(($timezone == 28)? print 'selected=""': print "")}}>Newfoundland (GMT-03:30)</option>
                                                <option value="29" {{(($timezone == 29)? print 'selected=""': print "")}}>Brasilia (GMT-03:00)</option>
                                                <option value="30" {{(($timezone == 30)? print 'selected=""': print "")}}>Buenos Aires (GMT-03:00)</option>
                                                <option value="31" {{(($timezone == 31)? print 'selected=""': print "")}}>Georgetown (GMT-03:00)</option>
                                                <option value="32" {{(($timezone == 32)? print 'selected=""': print "")}}>Greenland (GMT-03:00)</option>
                                                <option value="33" {{(($timezone == 33)? print 'selected=""': print "")}}>Mid-Atlantic (GMT-02:00)</option>
                                                <option value="34" {{(($timezone == 34)? print 'selected=""': print "")}}>Azores (GMT-01:00)</option>
                                                <option value="35" {{(($timezone == 35)? print 'selected=""': print "")}}>Cape Verde Is. (GMT-01:00)</option>


                                                <option value="36" {{(($timezone == 36)? print 'selected=""': print "")}}>Casablanca (GMT)</option>


                                                <option value="37" {{(($timezone == 37)? print 'selected=""': print "")}}>Dublin (GMT)</option>


                                                <option value="38" {{(($timezone == 38)? print 'selected=""': print "")}}>Edinburgh (GMT)</option>


                                                <option value="39" {{(($timezone == 39)? print 'selected=""': print "")}}>Lisbon (GMT)</option>


                                                <option value="40" {{(($timezone == 40)? print 'selected=""': print "")}}>London (GMT)</option>


                                                <option value="41" {{(($timezone == 41)? print 'selected=""': print "")}}>Monrovia (GMT)</option>


                                                <option value="42" {{(($timezone == 42)? print 'selected=""': print "")}}>Amsterdam (GMT+01:00)</option>


                                                <option value="43" {{(($timezone == 43)? print 'selected=""': print "")}}>Belgrade (GMT+01:00)</option>


                                                <option value="44" {{(($timezone == 44)? print 'selected=""': print "")}}>Berlin (GMT+01:00)</option>


                                                <option value="45" {{(($timezone == 45)? print 'selected=""': print "")}}>Bern (GMT+01:00)</option>


                                                <option value="46" {{(($timezone == 46)? print 'selected=""': print "")}}>Bratislava (GMT+01:00)</option>


                                                <option value="47" {{(($timezone == 47)? print 'selected=""': print "")}}>Brussels (GMT+01:00)</option>


                                                <option value="48" {{(($timezone == 48)? print 'selected=""': print "")}}>Budapest (GMT+01:00)</option>


                                                <option value="49" {{(($timezone == 49)? print 'selected=""': print "")}}>Copenhagen (GMT+01:00)</option>


                                                <option value="50" {{(($timezone == 50)? print 'selected=""': print "")}}>Ljubljana (GMT+01:00)</option>


                                                <option value="51" {{(($timezone == 51)? print 'selected=""': print "")}}>Madrid (GMT+01:00)</option>


                                                <option value="52" {{(($timezone == 52)? print 'selected=""': print "")}}>Paris (GMT+01:00)</option>


                                                <option value="53" {{(($timezone == 53)? print 'selected=""': print "")}}>Prague (GMT+01:00)</option>


                                                <option value="54" {{(($timezone == 54)? print 'selected=""': print "")}}>Rome (GMT+01:00)</option>


                                                <option value="55" {{(($timezone == 55)? print 'selected=""': print "")}}>Sarajevo (GMT+01:00)</option>


                                                <option value="56" {{(($timezone == 56)? print 'selected=""': print "")}}>Skopje (GMT+01:00)</option>


                                                <option value="57" {{(($timezone == 57)? print 'selected=""': print "")}}>Stockholm (GMT+01:00)</option>


                                                <option value="58" {{(($timezone == 58)? print 'selected=""': print "")}}>Vienna (GMT+01:00)</option>


                                                <option value="59" {{(($timezone == 59)? print 'selected=""': print "")}}>Warsaw (GMT+01:00)</option>


                                                <option value="60" {{(($timezone == 60)? print 'selected=""': print "")}}>West Central Africa (GMT+01:00)</option>


                                                <option value="61" {{(($timezone == 61)? print 'selected=""': print "")}}>Zagreb (GMT+01:00)</option>


                                                <option value="62" {{(($timezone == 62)? print 'selected=""': print "")}}>Athens (GMT+02:00)</option>


                                                <option value="63" {{(($timezone == 63)? print 'selected=""': print "")}}>Bucharest (GMT+02:00)</option>


                                                <option value="64" {{(($timezone == 64)? print 'selected=""': print "")}}>Cairo (GMT+02:00)</option>


                                                <option value="65" {{(($timezone == 65)? print 'selected=""': print "")}}>Harare (GMT+02:00)</option>


                                                <option value="66" {{(($timezone == 66)? print 'selected=""': print "")}}>Helsinki (GMT+02:00)</option>


                                                <option value="67" {{(($timezone == 67)? print 'selected=""': print "")}}>Istanbul (GMT+02:00)</option>


                                                <option value="68" {{(($timezone == 68)? print 'selected=""': print "")}}>Jerusalem (GMT+02:00)</option>


                                                <option value="69" {{(($timezone == 69)? print 'selected=""': print "")}}>Kyev (GMT+02:00)</option>


                                                <option value="70" {{(($timezone == 70)? print 'selected=""': print "")}}>Minsk (GMT+02:00)</option>


                                                <option value="71" {{(($timezone == 71)? print 'selected=""': print "")}}>Pretoria (GMT+02:00)</option>


                                                <option value="72" {{(($timezone == 72)? print 'selected=""': print "")}}>Riga (GMT+02:00)</option>


                                                <option value="73" {{(($timezone == 73)? print 'selected=""': print "")}}>Sofia (GMT+02:00)</option>


                                                <option value="74" {{(($timezone == 74)? print 'selected=""': print "")}}>Tallinn (GMT+02:00)</option>


                                                <option value="75" {{(($timezone == 75)? print 'selected=""': print "")}}>Vilnius (GMT+02:00)</option>


                                                <option value="76" {{(($timezone == 76)? print 'selected=""': print "")}}>Baghdad (GMT+03:00)</option>


                                                <option value="77" {{(($timezone == 77)? print 'selected=""': print "")}}>Kuwait (GMT+03:00)</option>


                                                <option value="78" {{(($timezone == 78)? print 'selected=""': print "")}}>Moscow (GMT+03:00)</option>


                                                <option value="79" {{(($timezone == 79)? print 'selected=""': print "")}}>Nairobi (GMT+03:00)</option>


                                                <option value="80" {{(($timezone == 80)? print 'selected=""': print "")}}>Riyadh (GMT+03:00)</option>


                                                <option value="81" {{(($timezone == 81)? print 'selected=""': print "")}}>St. Petersburg (GMT+03:00)</option>


                                                <option value="82" {{(($timezone == 82)? print 'selected=""': print "")}}>Volgograd (GMT+03:00)</option>


                                                <option value="83" {{(($timezone == 83)? print 'selected=""': print "")}}>Tehran (GMT+03:30)</option>


                                                <option value="84" {{(($timezone == 84)? print 'selected=""': print "")}}>Abu Dhabi (GMT+04:00)</option>


                                                <option value="85" {{(($timezone == 85)? print 'selected=""': print "")}}>Baku (GMT+04:00)</option>


                                                <option value="86" {{(($timezone == 86)? print 'selected=""': print "")}}>Muscat (GMT+04:00)</option>


                                                <option value="87" {{(($timezone == 87)? print 'selected=""': print "")}}>Tbilisi (GMT+04:00)</option>


                                                <option value="88" {{(($timezone == 88)? print 'selected=""': print "")}}>Yerevan (GMT+04:00)</option>


                                                <option value="89" {{(($timezone == 89)? print 'selected=""': print "")}}>Kabul (GMT+04:30)</option>


                                                <option value="90" {{(($timezone == 90)? print 'selected=""': print "")}}>Ekaterinburg (GMT+05:00)</option>


                                                <option value="91" {{(($timezone == 91)? print 'selected=""': print "")}}>Islamabad (GMT+05:00)</option>


                                                <option value="92" {{(($timezone == 92)? print 'selected=""': print "")}}>Karachi (GMT+05:00)</option>


                                                <option value="93" {{(($timezone == 93)? print 'selected=""': print "")}}>Tashkent (GMT+05:00)</option>


                                                <option value="94" {{(($timezone == 94)? print 'selected=""': print "")}}>Chennai (GMT+05:30)</option>


                                                <option value="95" {{(($timezone == 95)? print 'selected=""': print "")}}>Kolkata (GMT+05:30)</option>


                                                <option value="96" {{(($timezone == 96)? print 'selected=""': print "")}}>Mumbai (GMT+05:30)</option>


                                                <option value="97" {{(($timezone == 97)? print 'selected=""': print "")}}>New Delhi (GMT+05:30)</option>


                                                <option value="98" {{(($timezone == 98)? print 'selected=""': print "")}}>Kathmandu (GMT+05:45)</option>


                                                <option value="99" {{(($timezone == 99)? print 'selected=""': print "")}}>Almaty (GMT+06:00)</option>


                                                <option value="100" {{(($timezone == 100)? print 'selected=""': print "")}}>Astana (GMT+06:00)</option>
                                                <option value="101" {{(($timezone == 101)? print 'selected=""': print "")}}>Dhaka (GMT+06:00)</option>
                                                <option value="102" {{(($timezone == 102)? print 'selected=""': print "")}}>Novosibirsk (GMT+06:00)</option>
                                                <option value="103" {{(($timezone == 103)? print 'selected=""': print "")}}>Sri Jayawardenepura (GMT+06:00)</option>
                                                <option value="104" {{(($timezone == 104)? print 'selected=""': print "")}}>Rangoon (GMT+06:30)</option>
                                                <option value="105" {{(($timezone == 105)? print 'selected=""': print "")}}>Bangkok (GMT+07:00)</option>
                                                <option value="106" {{(($timezone == 106)? print 'selected=""': print "")}}>Hanoi (GMT+07:00)</option>
                                                <option value="107" {{(($timezone == 107)? print 'selected=""': print "")}}>Jakarta (GMT+07:00)</option>
                                                <option value="108" {{(($timezone == 108)? print 'selected=""': print "")}}>Krasnoyarsk (GMT+07:00)</option>
                                                <option value="109" {{(($timezone == 109)? print 'selected=""': print "")}}>Beijing (GMT+08:00)</option>
                                                <option value="110" {{(($timezone == 110)? print 'selected=""': print "")}}>Chongqing (GMT+08:00)</option>
                                                <option value="111" {{(($timezone == 111)? print 'selected=""': print "")}}>Hong Kong (GMT+08:00)</option>
                                                <option value="112" {{(($timezone == 112)? print 'selected=""': print "")}}>Irkutsk (GMT+08:00)</option>
                                                <option value="113" {{(($timezone == 113)? print 'selected=""': print "")}}>Kuala Lumpur (GMT+08:00)</option>
                                                <option value="114" {{(($timezone == 114)? print 'selected=""': print "")}}>Perth (GMT+08:00)</option>
                                                <option value="115" {{(($timezone == 115)? print 'selected=""': print "")}}>Singapore (GMT+08:00)</option>
                                                <option value="116" {{(($timezone == 116)? print 'selected=""': print "")}}>Taipei (GMT+08:00)</option>
                                                <option value="117" {{(($timezone == 117)? print 'selected=""': print "")}}>Ulaan Bataar (GMT+08:00)</option>
                                                <option value="118" {{(($timezone == 118)? print 'selected=""': print "")}}>Urumqi (GMT+08:00)</option>
                                                <option value="119" {{(($timezone == 119)? print 'selected=""': print "")}}>Osaka (GMT+09:00)</option>
                                                <option value="120" {{(($timezone == 120)? print 'selected=""': print "")}}>Sapporo (GMT+09:00)</option>
                                                <option value="121" {{(($timezone == 121)? print 'selected=""': print "")}}>Seoul (GMT+09:00)</option>
                                                <option value="122" {{(($timezone == 122)? print 'selected=""': print "")}}>Tokyo (GMT+09:00)</option>
                                                <option value="123" {{(($timezone == 123)? print 'selected=""': print "")}}>Yakutsk (GMT+09:00)</option>
                                                <option value="124" {{(($timezone == 124)? print 'selected=""': print "")}}>Adelaide (GMT+09:30)</option>
                                                <option value="125" {{(($timezone == 125)? print 'selected=""': print "")}}>Darwin (GMT+09:30)</option>
                                                <option value="126" {{(($timezone == 126)? print 'selected=""': print "")}}>Brisbane (GMT+10:00)</option>
                                                <option value="127" {{(($timezone == 127)? print 'selected=""': print "")}}>Canberra (GMT+10:00)</option>
                                                <option value="128" {{(($timezone == 128)? print 'selected=""': print "")}}>Guam (GMT+10:00)</option>
                                                <option value="129" {{(($timezone == 129)? print 'selected=""': print "")}}>Hobart (GMT+10:00)</option>
                                                <option value="130" {{(($timezone == 130)? print 'selected=""': print "")}}>Melbourne (GMT+10:00)</option>
                                                <option value="131" {{(($timezone == 131)? print 'selected=""': print "")}}>Port Moresby (GMT+10:00)</option>
                                                <option value="132" {{(($timezone == 132)? print 'selected=""': print "")}}>Sydney (GMT+10:00)</option>
                                                <option value="133" {{(($timezone == 133)? print 'selected=""': print "")}}>Vladivostok (GMT+10:00)</option>
                                                <option value="134" {{(($timezone == 134)? print 'selected=""': print "")}}>Magadan (GMT+11:00)</option>
                                                <option value="135" {{(($timezone == 135)? print 'selected=""': print "")}}>New Caledonia (GMT+11:00)</option>
                                                <option value="136" {{(($timezone == 136)? print 'selected=""': print "")}}>Solomon Is. (GMT+11:00)</option>
                                                <option value="137" {{(($timezone == 137)? print 'selected=""': print "")}}>Auckland (GMT+12:00)</option>
                                                <option value="138" {{(($timezone == 138)? print 'selected=""': print "")}}>Fiji (GMT+12:00)</option>
                                                <option value="139" {{(($timezone == 139)? print 'selected=""': print "")}}>Kamchatka (GMT+12:00)</option>
                                                <option value="140" {{(($timezone == 140)? print 'selected=""': print "")}}>Marshall Is. (GMT+12:00)</option>
                                                <option value="141" {{(($timezone == 141)? print 'selected=""': print "")}}>Wellington (GMT+12:00)</option>
                                                <option value="142" {{(($timezone == 142)? print 'selected=""': print "")}}>Nuku'alofa (GMT+13:00)</option>
                                            </select>
                                    </div>
                                    <div class="col-md-3 no-padding">
                                        <label>Tax Format:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="tax_format" name="tax_format" class="form-control lb-lg">
                                            <option value="">Select Format</option>
                                            <option value="tax" {{(($tax_format == 'tax')? print 'selected=""': print "")}}>TAX</option>
                                            <option value="vat" {{(($tax_format == 'vat')? print 'selected=""': print "")}}>VAT</option>
                                        </select>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding">
                                <div class="col-md-5 no-padding">
                                    <label>Certificate By:</label>
                                </div>
                                <div class="col-md-7">
                                    <input id="certificate_by" name="certificate_by" type="text"
                                           class="form-control lb-lg" value="{{$certificate_by}}"/>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding" style="padding-bottom: 8px !important">
                                <div class="col-md-5 no-padding">
                                    <label>Expiration Notice Message for Students:</label>
                                </div>
                                <div class="col-md-7">
                                    <textarea rows="5" id="expiration_notice_message" name="expiration_notice_message"
                                           class="form-control lb-lg" value="">{{$expiration_notice_message}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding" style="padding-bottom: 8px !important">
                                <div class="col-md-5 no-padding">
                                    <label>Suspension Notice Message for Students:</label>
                                </div>
                                <div class="col-md-7">
                                    <textarea rows="10" id="suspension_notice_message" name="suspension_notice_message"
                                              class="form-control lb-lg" value="">{{$suspension_notice_message}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12 no-padding" style="padding-bottom: 8px !important">
                                <div class="col-md-5 no-padding">
                                    <label>Donation Success:</label>
                                </div>
                                <div class="col-md-7">
                                    <textarea rows="10" id="donation_success" name="donation_success"
                                              class="form-control lb-lg">{{$donation_success}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr/>
                                <input type="button" id="save_settings" class="save_settings btn btn-primary" value="Save Settings"/>
                            </div>

                            <div class="col-md-12">
                                <br>
                                <hr/>
                                <h4>Bank Details</h4>
                                <hr/>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Bank:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="bank_details" name="bank_details" type="text"
                                               class="form-control lb-lg" value="{{$bank_details}}"/>
                                    </div>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Branch Address:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="branch_address" name="branch_address" type="text"
                                               class="form-control lb-lg" value="{{$branch_address}}"/>
                                    </div>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Sorting Code #:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="sorting_code_number" name="sorting_code_number" type="number"
                                               class="form-control lb-lg" value="{{$sorting_code_number}}"/>
                                    </div>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Beneficiary Name:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="beneficiary_name" name="beneficiary_name" type="text"
                                               class="form-control lb-lg" value="{{$beneficiary_name}}"/>
                                    </div>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Account #:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="account_number" name="account_number" type="text"
                                               class="form-control lb-lg" value="{{$account_number}}"/>
                                    </div>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Bank's Address:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="bank_address" name="bank_address" type="text"
                                               class="form-control lb-lg" value="{{$bank_address}}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <br>
                                <hr/>
                                <h4>Sagepay Controls</h4>
                                <hr/>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Vendor:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="sagepay_vendor" name="sagepay_vendor" type="text"
                                               class="form-control lb-lg" value="{{$sagepay_vendor}}"/>
                                    </div>
                                </div>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>Encrypted Password:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="sagepay_encrypted_password" name="sagepay_encrypted_password" type="text"
                                               class="form-control lb-lg" value="{{$sagepay_encrypted_password}}"/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <br>
                                <hr/>
                                <h4>PayPal Controls</h4>
                                <hr/>
                                <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>PayPal Id:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="paypal_id" name="paypal_id" type="text"
                                               class="form-control lb-lg" value="{{$paypal_id}}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr/>
                                <input type="button" id="save_settings" class="save_settings btn btn-primary" value="Save Settings"/>
                            </div>

                            <div class="col-md-12">
                                    <br>
                                    <hr/>
                                    <h4>Twilio API Information (SMS)</h4>
                                    <hr/>
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-5 no-padding">
                                            <label>Account SID:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="twilio_account_sid" name="twilio_account_sid" type="text"
                                                   class="form-control lb-lg" value="{{$twilio_account_sid}}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-5 no-padding">
                                            <label>Auth Token:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="twilio_auth_token" name="twilio_auth_token" type="text"
                                                   class="form-control lb-lg" value="{{$twilio_auth_token}}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-5 no-padding">
                                            <label>Twilio Number:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="twilio_number" name="twilio_number" type="text"
                                                   class="form-control lb-lg" value="{{$twilio_number}}"/>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <br>
                                    <hr/>
                                    <h4>Mandrillapp API Information (Email)</h4>
                                    <hr/>
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-5 no-padding">

                                            <label>Host:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="mandrill_host" name="mandrill_host" type="text"
                                                   class="form-control lb-lg" value="{{$mandrill_host}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-5 no-padding">
                                            <label>Port:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="mandrill_port" name="mandrill_port" type="text"
                                                   class="form-control lb-lg" value="{{$mandrill_port}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12 no-padding">
                                        <div class="col-md-5 no-padding">
                                            <label>SMTP Username:</label>
                                        </div>
                                        <div class="col-md-7">
                                        <input id="mandrill_smtp_username" name="mandrill_smtp_username" type="text"
                                               class="form-control lb-lg" value="{{$mandrill_smtp_username}}"/>
                                    </div>
                                    </div>
                                    <div class="col-md-12 no-padding">
                                    <div class="col-md-5 no-padding">
                                        <label>API Key:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input id="mandrill_api_key" name="mandrill_api_key" type="text"
                                               class="form-control lb-lg" value="{{$mandrill_api_key}}"/>
                                    </div>
                                 </div>
                                </div>


                                <div class="col-md-12">
                                    <hr/>
                                    <input type="button" id="save_settings" class="save_settings btn btn-primary" value="Save Settings"/>
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                    </form>
                    </div>
                </div>
            </div>
        </div>

    <script>


        (function () {
            setTimeout(function () {
                $('.alert-success').fadeOut('slow');
            }, 3000); // <-- time in milliseconds
            setTimeout(function () {
                $('.alert-danger').fadeOut('slow');
            }, 3000); // <-- time in milliseconds

            $(".save_settings").click(function (e) {
                e.preventDefault();

                //min length
                // if ($('#overdue_assignment_duration').val().length <= 0) {
                //     $('#overdue_assignment_duration_errors').text('Days value must be a number');
                //     return false;
                // } else {
                //     $('#overdue_assignment_duration_errors').text('');
                // }
                // if ($('#priority_students_marking_duration').val().length <= 0) {
                //     $('#priority_students_marking_duration_errors').text('Days value must be a number');
                //     return false;
                // } else {
                //     $('#priority_students_marking_duration_errors').text('');
                // }


                $.ajaxSetup({
                    headers: {
                        'X-XSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formdata = new FormData($("#system_settings_form")[0]);
                console.log("formdata");
                console.log(formdata);

                $.ajax({
                    url: '{{ url('/settings/system-settings/') }}',
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log('response');
                        console.log(response);
                        if(response == 'Success'){
                            $("#success-alert").css("height", "50px");
                            $('#success-alert').html('<h3>Settings Updated Successfully</h3>');
                            $('#success-alert').focus();
                            $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                                $("#success-alert").css("height", "0px");
                                $("#success-alert").css("display", "block");
                            });
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        console.log('scroll error'+error_scroll);
                        $('#'+error_scroll).focus();
                    }
                });
            });
        })();
    </script>
@endsection