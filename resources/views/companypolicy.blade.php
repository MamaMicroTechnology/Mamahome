<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MamaHome</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
    body{
        font-family: "Times New Roman";
    }
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        
        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }
        
        .sidenav a:hover {
            color: #f1f1f1;
        }
        
        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        
        #main {
            transition: margin-left .5s;
            padding: 16px;
        }
        
        @media screen and (max-height: 450px) {
          .sidenav {padding-top: 15px;}
          .sidenav a {font-size: 18px;}
        }
    /*******************************Calendar Top Navigation*********************************/
div#calendar{
    margin:0px auto;
    padding:0px;
    width: 602px;
    font-family:Helvetica, "Times New Roman", Times, serif;
  }
   
  div#calendar div.box{
      position:relative;
      top:0px;
      left:0px;
      width:100%;
      height:40px;
      background-color:   #787878 ;      
  }
   
  div#calendar div.header{
      line-height:40px;  
      vertical-align:middle;
      position:absolute;
      left:11px;
      top:0px;
      width:582px;
      height:40px;   
      text-align:center;
  }
   
  div#calendar div.header a.prev,div#calendar div.header a.next{ 
      position:absolute;
      top:0px;   
      height: 17px;
      display:block;
      cursor:pointer;
      text-decoration:none;
      color:#FFF;
  }
   
  div#calendar div.header span.title{
      color:#FFF;
      font-size:18px;
  }
   
   
  div#calendar div.header a.prev{
      left:0px;
  }
   
  div#calendar div.header a.next{
      right:0px;
  }
   
   
   
   
  /*******************************Calendar Content Cells*********************************/
  div#calendar div.box-content{
      border:1px solid #787878 ;
      border-top:none;
  }
  div#calendar ul.label{
      float:left;
      margin: 0px;
      padding: 0px;
      margin-top:5px;
      margin-left: 5px;
  }
  div#calendar ul.label li{
      margin:0px;
      padding:0px;
      margin-right:5px;  
      float:left;
      list-style-type:none;
      width:80px;
      height:40px;
      line-height:40px;
      vertical-align:middle;
      text-align:center;
      color:#000;
      font-size: 15px;
      background-color: transparent;
  }
  div#calendar ul.dates{
      float:left;
      margin: 0px;
      padding: 0px;
      margin-left: 5px;
      margin-bottom: 5px;
  }
  /** overall width = width+padding-right**/
  div#calendar ul.dates li{
      margin:0px;
      padding:0px;
      margin-right:5px;
      margin-top: 5px;
      vertical-align:middle;
      float:left;
      list-style-type:none;
      width:80px;
      height:80px;
      font-size:12px;
      background-color: #DDD;
      color:#000;
      text-align:center; 
  }
   
  :focus{
      outline:none;
  }
   
  div.clear{
      clear:both;
  }
</style>
</head>
<body>
    <div class="container text-justify" id="app">
        <h2><center><u>COMPANY POLICY</u></center></h2>
    <h3>Contents</h3>
    <ol>
        <li>The employees will perform duties as assigned by the company from time to time relating to the position to which the employee is now appointed and to which he/she may be transferred / deputed / seconded / promoted in future. Employees shall comply with all reasonable orders of superiors and attend to duties punctually at such place / places, as may be required at the relevant time.</li>
        <li>Employee may be entrusted with the handling of cash and other properties / assets of the Company; any short fall will be recoverable personally. The employee will not preclude the company from recovering the same from any dues, or from taking legal action.</li>
        <li>Employees should use their best endeavors to promote the interests of the company and their conduct at other times shall be such as not to damage the interest of the Company. </li>
        <li>Employee’s performance and progress will be assessed and appraised from time to time as per the performance appraisal/evaluation process or any other appropriate mechanism, as per schedules implemented by the company from time to time.</li>
        <li>In consideration of employee’s effective service, he/she will be eligible for a remuneration of… which shall pay only after deducting taxes, duties and other statutory dues.</li>
        <li>All other benefits/perquisites will be as per Companies rules/procedures/schedules, in force and will be subject to deduction of appropriate taxes at sources and other statutory liabilities arising on his/her account.</li>
        <li>Details of compensation package are strictly confidential between the employee and the Company. The details are not liable for disclosure by employee to any third party, without the Companies formal prior consent.</li>
        <li>Employee shall not have any right to interfere in the management of affairs of the company.</li>
        <li>Employee shall not question any decisions of the Shareholders/Board of Directors/Management of the Company, except in any matter, which is contrary to the agreement.</li>
        <li>Employees shall not claim any right in the company or its products or services.</li>
        <li>All rights relating to products developed or services provided by the company shall vests with the company alone even if it is developed/produced/provided with your help, and the company have the right to register patent/trademark/copy rights in its name for the products and services developed/provided even if it is developed/provided with the help of the employee.</li>
        <li>The employees will faithfully observe and be governed by the Companies rules and regulations on matters such as working hours, festivals/public holidays, weekly off and any other facilities/amenities, mode of recording attendances, safety and security requirements, medical fitness, personal identification, previous salary slips, 2 photos, educational qualification details/documents etc., and operate with due regard to the highest professional standards/ethics in all transactions.</li>
        <li>Employees are not allowed to open or register any other job/bio data updating & registration sites/job portals (*Timesjobs.com, Monster.com, UPSC, PSC, and Naukri.com etc.), using company systems and internet. Company is not against the employees’ search for a better opportunity but such personal updating and job searching inside the company is strictly prohibited, it must be done from outside the company/organization. If found against the company rule, disciplinary actions will be taken with immediate effect.</li>
        <li>The Company may re-fix/modify the employee’s designation, grade and distribution of his/her compensation into different components as per designation/grade/benefits/perquisites structures implemented by the Company from time to time at their sole discretion.</li>
        <li>Employees are required to submit originals of various documents in respect of his/her identity (Identity Proof, Adhar Card is a must), qualification, work experience, pay slips of last three months (only if experienced candidate), 2 passport size photos etc. and fulfill different joining formalities at the time of reporting for duties (*must be completed on first working day) for better verification process and documentation. If found the details are fabricated, immediate actions will be taken by the company. All documents’ copies must be submitted for documentation and filing at the time of joining itself.  The Original Certificates will be return right after the verification process.</li>
        <li style="color:red;">60 days of Notice Period must be served by the employee, once he/she wants to relieve/job change/resign from the company with all the benefits of previous employment like Experience Letter, Last Month Salary, Relieving Letter and Conduct Certificate. If not served the given notice period by the company, strict legal actions will be taken from the company side and that employee will be under Terminated List. The Employee who left the job without serving the notice period of 60 days, will be responsible for the loss of the company interests. Terminated employees will not get the last month salary. Exceptions can be made with the early notification or communications with CEO/MD.</li>
        <li style="color:red;">Notice period of 60 days can be adjusted with your available leave balance, if there is any. Such decisions can be taken with the intimation of CEO/MD</li>
        <li>Employee should consult with all the departments or reporting managers about the completion of their resignation process. Make sure that he/she gets the confirmation letter on the same by Written & Email signed by the HR and Managing Director of the company.</li>
        <li>Each & Every employee, who is separating from this company/organization, must go through an Exit Interview, the moment an employee becomes disengaged until his or her departure from the organization. This is the key time that an exit interview should be administered because the employee’s feelings regarding his or her departure are fresh in mind. An off-boarding process allows both the employer and employee to properly close the existing relationship so that company materials are collected, administrative forms are completed, knowledge base and projects are transferred or documented, feedback and insights are gathered through exit interviews, and any loose ends are resolved. Those who are not following the Exit Interview process properly, will not be relieved with the benefits of previous employment such as experience letter, conduct certificate etc.</li>
        <li>Those who are completing these exit procedures without any failure will get a direct recommendation & appreciation letter and mail from the company side for the good service you provided to the company, when it comes to your new job verification process</li>
        <li>Employees are highly responsible to keep a track/soft copy on every work assigned. Everything he/she does inside the company related to assigned work, must be with the permission and confirmation of their reporting manager via email. For every work-related mail, keep the concerned Reporting Manager, HR and Managing Director in the loop (Cc & Bcc).</li>
        <li style="color:red;">Employees are strictly responsible to send work status by email (*screenshots if working with PC/Laptops/Tab) during every 01:30:00 hours. There will not be any written or verbal notification on the same, it is applicable for every single employee from the time they start their respective work.</li>
        <li>Employees are not allowed to promote/administrate/create/manage any kind of political party/politicians’/banned organizations/violent content/abusive content pages or sites or blogs, from or within the company, using company equipments like PC/Laptop/Tab/Mobile and company working hours. If any such actions being found, it will be considered as against the company and management policy.</li>
        <li>Employees are asked to use the dust bin/waste basket on a regular basis if he/she feel like to deposit unwanted things/waste. Anything from paper waste to food waste, if found on floor or inside the company premises will lead to penalty decided by the company or management after the enquiry.</li>
        <li>Late coming or early exits are not permitted. One-day late entry or two days late entry, late entry is and will always consider as late entry and it will be subjected to disciplinary actions decided by the CEO/MD. Exceptions can be made, if there is a proper intimation by HR and approval of CEO/MD</li>
        <li>Early exits from the given working time will be subjected to any disciplinary actions decided by the CEO/MD. Exceptions can be made, if there is a proper intimation by HR and approval of CEO/MD</li>
        <li>Attendance marking will be under strict monitoring. Anything which is not going through a proper way or any kind of attempt to forgery (changing the actual Time In, Time Out, striking without the permission of the reporting manager, False Time In, False Time Out) will lead to disciplinary actions and termination if found repeated.</li>
        <li>Leave must be applied before two days of the desired day of leave through email or SMS to the responsible person. Leave should be approved by the HR and Managing Director/CEO via email.</li>
        <li>Sick Leave will be acceptable only after the submission of proper documents/prescription along with Doctor Certificate on or after the leave, if not such days will be adjusted with your available annual leaves. And if there are no available leave balance in your credit, it will be considered as informed leave without pay.</li>
        <li>Employees will not be granted paid sick leaves without submitting the documents and doctor certificate or medical certificate. If the employee does not have any annual leave balance, the leave days will be considered as loss of pay (exceptions can be made after the discussion with CEO/MD along with needed documents or explaining the situation with proper reference).</li>
        <li>Employees are not allowed to work on the Company given Holidays or Weekly Off, without the permission and confirmation from higher authority (managing director/CEO).</li>
        <li>If allowed to work on any kind of non-working day and Holidays, the employee will be getting a day Compensatory Off (Comp Off) from work. Available Compensatory Offs will be taken within 3 months of time, after three months, pending Compensatory Offs will be removed.</li>
        <li>More than 10 Compensatory Offs will not be allowed</li>
        <li>There will not be any cash compensation for Compensatory offs or any other leave balance.</li>
        <li>Employees must take or use half of the given Annual Leave in the same working year itself. Another half of the annual leave will carry forward to the next working year, if it is not used already.</li>
        <li>Sick Leaves will not be carried forward.</li>
        <li>Every employee is asked to take half of their Total Annual Leave per year (includes carry forward leave) in the same working year. It is applicable to everyone. It is compulsory.</li>
        <li>Company or Management are authorized to change any kind of leave policies in consideration of the situation, needs of the company and its’ clients. If any such changes will happen to the current policy, it will be informed at the earliest to the employees. Company have all the rights to take the final decision.</li>
        <li>
          During the currency of employment with us employees are not authorized to<br>
          <ul>
            <li>Accept directly or indirectly any commission, share in profit, presents, gifts or gratuities from any third party dealing with the Company in any mode or from whatsoever.</li>
            <li>Represent themselves as an authorized representative of the company, except to the extent of being specifically and formally authorized to do so.</li>
            <li>Communicate with or speak/write or in any other manner interact with media (print/electronic or otherwise) or with any other external agencies on behalf of the Company, on matters concerning the Company, their associates, etc… save to the extent of performance of any of his/her statutory obligations for which he/she is specifically authorized by the Company.</li>
          </ul>
        </li>
        <li>Employees will not, without prior consent of the Company in writing or via Email or by Text, which will not be unreasonably withheld, publish any book or brochure or article concerning any matter, which relates to any area of activity of the Company. Company’s decision regarding the consent shall be final and binding on the employee.</li>
        <li>Employees will not accept directly or indirectly any commission, share in profit, presents or gratuities from any party dealing with, or seeking to deal with the Company or its affiliates. Employees will inform the Company without delay any act of dishonesty, fraud or cheating or any damage to the Company’s property that he/she may come to know of whether the same is under contemplation or is taking place or has already taken place.</li>
        <li>Employee shall not solicit, canvass, or accept any business or transaction for any other person, firm, or corporation or business similar to any business of the Company or its affiliates.</li>
        <li>Employee shall not induce, or attempt to influence, any employee of the company or its affiliates to terminate employment with the company or its affiliates, or to enter into any employment or other business relationship with any other person, firm or corporation.</li>
        <li>Employee shall not at any time enter into any contract with any person, firm or corporation that shall purport to bind the Company in any manner whatsoever without written authority from the Company and any such contract entered into by such employee shall not be binding upon the Company.  The Company specifically reserves the right to reject any contract or to cancel any contract or part thereof even after acceptance, for credit reasons or for any other reason whatsoever that the Company may deem appropriate.</li>
        <li>Employee’s appointment and continuation on the Company’s rolls are in good faith and shall be based on the data, information or any other understanding provided during the course of selection process, including the verbal information provided during the interviews/personal discussions. Any data that is not inconsonance with the information provided shall result in immediate termination of employment with the Company and he/she shall indemnify the Company in full, for any loss suffered by the Company. Company reserves the right to make suitable formal and informal checks with his/her educational institutions, former employers, and any other third parties, as the Company may deem appropriate.</li>
        <li>During the currency of employment with the company employees shall not engage directly or indirectly in any trade, business, or occupation or in any advisory capacity</li>
        <li>After separation from the company’s employment in any manner (including retirement), he/she shall not engage in a business in any manner similar to or in competition with the Company's business for a period of 6 months from the date of termination of employment with the Company.</li>
        <li>After separation from the company’s employment in any manner (including retirement), the employee shall not start any business with a name which is similar to the name of the company or shall not use company’s name for marketing your business.</li>
        <li>
          Employee’s agreement can be terminated by the company, without any notice, in the following cases:<br>
          <ul>
            <li>Any incorrect information furnished or on suppression of any material information.</li>
            <li>Any act which in the opinion of the management is an act of dishonesty, disobedience, insubordination, incivility, intemperance, irregularity in attendance or other misconduct or neglect of duty or incompetence in the discharge of duty on his/her part or the breach on his/her part of any of the terms, conditions or stipulation contained in the agreement or a violation on his/her part of any of the company’s rules.</li>
            <li>He/she being adjudged an insolvent or applying to be adjudged an insolvent or making a composition or arrangement with creditors or being held guilty by a competent court of any offence involving moral turpitude.</li>
            <li>Unauthorized absence from work, of failure to resume duties on expiry of the leave duly authorized by the company.</li>
          </ul>
        </li>
        <li>Employees are bound to achieve the minimum target fixed by the company from time to time. On failing to achieve the minimum target, the Company reserves the right to reduce salary and terminate employment without notice during the currency of employment, if failed to match the minimum target constantly.</li>
        <li>The employee’s appointment is subject to a probation period of six months. He/she will be considered for confirmation at the end of the probation period subject to successful completion of the pre-confirmation performance review process. The probation period shall be deemed to have been extended unless formally and specifically advised otherwise by the company.</li>
        <li>Subject to the companies’ right to terminate his/her employment in accordance the provisions specified, the employment after confirmation may be terminated by either party, by providing a formal notice of minimum one month to the other party.</li>
        <li>At the time of the separation from the company’s employment in any manner (including retirement) he/she will comply with all procedures and requirements connected with the separation including the formalities concerning handing over of all papers, documents, floppies CD’s and any other valuables, property and other assets, etc. belonging to the company. Final settlement of dues and issuance of a certificate of employment shall be completed by the Company after all the separation requirements completed in full.</li>
        <li style="color:red;">In the event that the employee becomes disabled because of physical or mental disability as to be unable to perform the services required by this agreement and such disability continues for 120 days, the Company may, at or after the expiration of such 120 days period (provided that the Your incapacity is then continuing) terminate the Your employment under this agreement.  It is expressly understood that you’re to render services to the Company by reason of illness, disability or incapacity or any cause beyond your control. Shall not constitute a failure to perform your obligations hereunder and shall not be considered a breach or default under this agreement.</li>
        <li>In the event of death, the Company shall pay to his/her legal heirs all funds due, as of the date of death.</li>
        <li>In the event that the employee violates any of the provisions of agreement or fails to perform the services required by his/her agreement, then at the option of the Company, this agreement shall at once cease and become null and void and the Company shall be under no obligation.</li>
        <li>Any kind of actions or communications or hand of god activities against this agreement, company policies, rules and regulations will result in Termination and Legal Actions against the employee.</li>
        <li>This policy constitutes the entire understanding between the employee and the company relating to his/her employment in the Company and supersedes and cancels all prior written and verbal agreements and understanding with respect to the subject matter of this appointment. This agreement may be amended by a subsequent written agreement between the employee and the Company.</li>
    </ol>
    <br>
    <center><a href="{{ URL::to('/') }}/accept?UserId={{Auth::user()->id}}" class="btn btn-success">Accept</a></center>
    </div>
    <br><br>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }
        
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }
    </script>
</body>
</html>
