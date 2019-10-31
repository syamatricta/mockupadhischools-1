<div style="font-family:sans-serif;">
    <table width="625">
        <tbody>
            <tr><th style="font-size: 22px; padding: 20px 0px; text-align: left; border-bottom: 5px solid #8EE41D;">Are You Ready For A New Career In Real Estate?</th></tr>
            <tr><td style="font-size:12px; padding: 20px 5px;  color:#7C7C7C; line-height:20px; text-align: justify; border-bottom: 2px solid #8EE41D;">Greetings!<br/> Thank you for enquiring about our program. The opportunities are endless when you have a career in real estate. In this rewarding industry you will have the chance to make dreams come true while fulfilling your own. With your license you may sell, list and or lease single family residences, income property, commercial property and land! There is business to be made, so let's get you started today!</td></tr>
            <tr>
                <td>
                    <table style="width: 100%;">
                        <tbody>
                            <tr style="font-size: 16px; font-weight:bold;">
                                <td colspan="2" style="padding: 20px 0px;text-align: center;">The following videos explain how to become a<br/>salesperson and broker</td>
                            </tr>
                            <tr style="font-size: 12px; text-align: center; vertical-align: top;">
                                <td style="text-align: left;">
                                    <div class="video_link">
                                        <a href="http://www.youtube.com/watch?v=xjdOgxTSPYo"><img src="<?php echo $this->config->item('images'); ?>emailer-copy_05.jpg" alt="Getting a real estate salesperson license in California"/></a>
                                    </div>
                                    <div style="padding-top:10px;text-align: center;">Getting a real estate salesperson<br/>license in California</div>
                                </td>
                                <td style="text-align: right;">
                                    <div class="video_link">
                                        <a href="http://www.youtube.com/watch?v=sJf6TCAIs8Q"><img src="<?php echo $this->config->item('images'); ?>emailer-copy_09.jpg" alt="How to obtain a brokers license in California"/></a>
                                    </div>
                                    <div style="padding-top:10px;text-align: center;">How to obtain a brokers<br/>license in California</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding: 20px 0px;text-align: center;"><img src="<?php echo $this->config->item('images'); ?>emailer-copy-11.jpg">
                    <br/>
                    <span style="font-size: 14px;"><h2 style="margin: 0px;">ADHI Class Locations & Maps</h2>
                        (Links provided below)<br/><span style="color:#085698;">South California</span></span>
                </td>
            </tr>
            <tr>
                <td style="">
                    <table style="width: 100%;">
                        <tbody>
                            <?php
                                if (isset($course_region))
                                {
                                    $i = 1;
                                    foreach ($course_region as $cr)
                                    {
                                        if ($i == 1)
                                        {
                                            echo '<tr  style="padding: 10px 0px;">';
                                        }
                                        ?>
                                    <td style="font-size: 12px; padding: 25px 5px 25px 0px; vertical-align: top;">
                                        <span style="font-size: 14px;padding:5px 0px"><?php echo $cr->subregion_name; ?></span><br/>
                                        <span style="color:#008F7D;"><?php echo $cr->day; ?> - <?php echo $cr->time; ?></span><br/>
                                        <span style="line-height:20px; font-size: 12px;">
                                            <a href="http://maps.google.com/maps?q=<?php echo urlencode($cr->subregion_address) ?>"  target='_blank' style="color:#7C7C7C;">
                                                <?php echo $cr->subregion_address; ?>
                                            </a>
                                        </span>
                                    </td>

                                    <?php
                                    $i++;
                                    if ($i > 3)
                                    {
                                        echo '</tr>';
                                        $i = 1;
                                    }
                                }
                            }
                        ?>
                        <tr><td colspan="3" style="padding:20px 0px;font-size: 12px;"> Please view our schedule at the following link : <a href="www.adhischools.com/schedule">www.adhischools.com/schedule</a></td></tr>
        </tbody>
    </table>
</td>
</tr>

<tr>
    <td style="border:1px solid #EDE9E3; padding:0px;">
        <table style="width: 100%;" cellspacing="0" cellpadding="5">
            <tbody>
                <tr>
                    <td style="background-color: #8EE41D; padding:10px 25px; text-align:left;">
                        <h3>ADHI Terms & Pricing</h3>
                        <span style="font-size: 12px;">All enrollments are valid for 1 year - longest of any schools in the state to our knowledge<br/>(most are for 6 months - 1 year) Materials are included with each package</span>
                    </td>
                </tr>
                <tr>
                    <td  style="font-size: 12px; padding:10px 25px; text-align:justify;">
                        <br/><br/>
                        <strong>Packages - Available on our website, over the phone or in class.</strong><br/><br/>
                        All 3 classes online: <span style="font-weight: bold;font-size: 14px; color:#F15500;">$169</span>- including books, streaming video lectures, online quizzes, final exams and certificates (cheapest of any school in the state for online with textbooks - not large PDF files) <br/><br/>
                        Principles and Practice <span style="font-weight: bold;font-size: 14px; color:#085698;">live</span> optional classes and online access, with 2 day crash course and 1,000+ practice exam questions<span style="font-weight: bold;font-size: 14px; color:#F15500;">($399)</span> - For students that have taken an economics/accounting/business law class in college - no matter how long ago it was.<br/><br/>
                        Principles, Practice and Elective<span style="font-weight: bold;font-size: 14px; color:#085698;">live</span> optional classes and online access, with a 2 day crash course and 1,000+ practice exam questions <span style="font-weight: bold;font-size: 14px; color:#F15500;">($499)</span><br/><br/>
                        <br/><br/>
                        <strong>A la carte:</strong><br/><br/>
                        <table style="font-size: 12px;width: 100%;">
                            <tbody>
                                <tr>
                                    <td>Principles optional live: <span style="font-weight: bold;font-size: 14px; color:#F15500;">$249</span></td>
                                    <td>Elective optional live:<span style="font-weight: bold;font-size: 14px; color:#F15500;">$129</span></td>
                                </tr>
                                <tr>
                                    <td>Practice optional live: <span style="font-weight: bold;font-size: 14px; color:#F15500;">$129</span></td>
                                    <td>Elective home study:<span style="font-weight: bold;font-size: 14px; color:#F15500;">$75</span></td>
                                </tr>
                            </tbody>
                        </table><br/><br/>
                        <span style="font-weight: bold;font-size: 14px; color:#F15500;">$69</span> - Practice questions with video explanations<br/>
                        <span style="font-weight: bold;font-size: 14px; color:#F15500;">$129</span> - Practice questions with video explanations and stream archived crash course with included workbook<br/>
                        <span style="font-weight: bold;font-size: 14px; color:#F15500;">$199</span> - Practice questions with video explanations and stream archived crash course with included workbook and access to ourr live two day crash course<br/>
                        <br/><br/>
                        <strong>Elective Classes:</strong><br/><br/>
                        Legal Aspects of Real Estate - Economics - Escrows - Appraisal - Finance - Property Management<br/>
                        <span style="color:#085698;">If these classes are added on to an existing package, prices will be $99 for live and $56 online.</span><br/><br/>
                        Students are required to spend 45 hours with the course material per course<br/><br/>
                    </td>
                </tr>
                <tr><td style="text-align:center;"><h4>Easy registration for these classes can be found on our<br/>website: <a href="http://www.adhischools.com">www.adhischools.com</a></h4></td></tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table width="100%">
            <tbody>
                <tr>
                    <td style="text-align:left; font-size:12px;">
                        <div>
                            <span style="display:block;">
                                <a href="http://www.youtube.com/watch?v=HebK5BqDqXs">
                                    <img src="<?php echo $this->config->item('images'); ?>emailer-copy_21.jpg" alt=""/>
                                </a>
                            </span><br/>
                            <span>Interview with Robert Adams - Realtor</span>
                        </div>
                    </td>
                    <td style="text-align:right; font-size:12px;">
                        <div style="text-align:center;"">
                            <span style="display:block;">
                                <a href="http://www.adhischools.com">
                                    <img src="<?php echo $this->config->item('images'); ?>emailer-copy_22.jpg" alt=""/>
                                </a>
                            </span><br/>
                            <span>888-768-5285<br/>info@adhischools.com</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table width="100%">
            <tbody>
                <tr>
                    <td style="text-align:center;">
                        <span style="padding:0px 5px;"><a href="http://www.yelp.com/biz/adhi-schools-newport-beach"><img src="<?php echo $this->config->item('images'); ?>emailer-copy_25.jpg" alt=""/></a></span>
                        <span style="padding:0px 5px;"><a href="https://facebook.com/adhischools/"><img src="<?php echo $this->config->item('images'); ?>emailer-copy_27.jpg" alt=""/></a></span>
                        <span style="padding:0px 5px;"><a href="https://twitter.com/adhischools/"><img src="<?php echo $this->config->item('images'); ?>emailer-copy_29.jpg" alt=""/></a></span>
                        <span style="padding:0px 5px;"><a href="http://www.adhischools.com/blog/"><img src="<?php echo $this->config->item('images'); ?>emailer-copy_31.jpg" alt=""/></a></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td style="text-align: center;"><span style="color: #8E8E8E;">ADHI Schools, LLC | 1063 West 6th Street | Second Floor | Ontario | CA | 91762</span></td>
</tr>
</tbody>
</table>
</div>