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
        <h2><center><u>CONFIDENTIALITY POLICY</u></center></h2>
    <h3>Contents</h3>
    <ol>
        <li><a href="#scope">Scope of the Policy</a></li>
        <li><a href="#policy">Policy Statement</a></li>
        <li><a href="#know">Know-How</a></li>
        <li><a href="#coypright">Copyright and other Intellectual Property</a></li>
        <li><a href="#communication">Communication and Review</a></li>
    </ol>
    <u id="scope"><b>Scope of the Policy</b></u><br><br>
    <p><b>MAMA HOME Pvt Ltd does not entertain part-time employment.</b></p>
    <p>During the course of Employee’s employment, they will have access to and be entrusted with Confidential Information and Know-How</p>
    <p>“Confidential Information” means all and any information in whatever form whether disclosed orally or in writing or whether eye
    readable, machine readable or in any other form including, without limitation,  concerning the Company’s business and finances,
    technical procedures and intellectual property rights, know-how, including details of prospective clients; its dealings,
    transactions and affairs; its products and services; customers and suppliers information;  financial projections, targets
    and accounts; pricing policies and pricing statistics; commercial activities, product development and future plans; and similar
    information concerning the Company’s clients, customers and suppliers, all of which information is acknowledged by the Employee to be:-</p>
        <ul>
        <li>Confidentiality to the Company</li>
        <li>Commercially sensitive in the Company’s market; and</li>
        <li>Potentially damaging to the Company’s financial stability if disclosed to a third party</li>
        </ul>
    <u id="policy"><b>Policy Statement</b></u>
    
    <p>The employee hereby agrees that he/she shall hold in confidence and hereby agree that he/she shall not use,
    communicate or disclose expect under the terms of the company and only at specific behest of company, any
    confidential information to any person or entity, or else under provision governed by this policy. The company may provide such approval in writing.</p>
    <p>
    The employee agrees that even upon termination of his/her association with the company, employer undertakes
    not to make use of confidential information in his/her business, or provide the same to third party in pursuance
    of their business whether in role of consultation or employee. As per this policy the employee undertakes to use at
    least the same degree of care in safeguarding the confidential information as he/she uses or would use in safeguarding
    his/her own confidential information, and shall take all steps necessary to protect the confidential information
    from unauthorised or inadvertent disclosure.</p>
    <p>
    The employee agrees during the course of the employment inclusive of his/her direct beneficiaries in business,
    interest and title in recognition of the disclosure of confidential and proprietary information owned by the
    company hereby aggress not to directly or indirectly compete with the business of Company and its successors
    and assign during the term of employment in the company and even after following the expiration or termination of
    this policy and notwithstanding the cause or reason for termination. Any breach of this policy is said deemed to be
    serious offence and shall be liable to the full extent of the law.</p>
    
    <p>The employer agrees to surrender all they material print based or in electronic form comprising the confidential
    information to the company. Any material owned by the company, and is in   the possession of the employer shall be
    deemed to be breach of this policy and shall make the employer libel to full extent of the law. Which it may also
    cause serious damage to the reputation and standing of MAMA HOME.</p>
    
    <p>During the continuance of the Employee’s employment they shall use their best endeavours to prevent the divulgence or
    disclosure by third parties of the Confidential Information or the Know-how.</p>
    
    <p>Nothing in this statement affects the Executive’s rights under the Public Interest Disclosure Act 1998.</p>
    
    <u id="know"><b>Know-How</b></u>
    <p>Which include all existing intellectual property in the nature of unregistered and registered right to any and all
    copyright, trademark and other confidential/propriety information not limited to that forming part of the subject matter
    transfer and inclusive of all intellectual property that is subject of ownership of MAMA HOME PVT LTD and its subsidiaries,
    venture partner and predecessors in interest, business and title.<br>
    The Employee acknowledges: -</p>
    <ol type="a">
        <li>That the disclosure at any time during their employment or following the termination of their employment of information,
        knowledge, data, trade secrets, inventions, programs and other matters concerning the Company’s business whether in existence
        before their employment or created during their employment (hereinafter referred to as the “Know-how”) to any third-party places
        the Company at a serious competitive disadvantage and would cause immeasurable financial and other damage to the Company.</li>
        <li>That in the course of their employment they have access to the know-how and may (whether alone or with any other person or persons)
        have created the know-how which relates either directly or indirectly to the Company’s business.</li>
        <li>The Employee confirms that the know-how is and will remain the sole property of the Company and that any interest in the
        know-how vested in them is held only in trust for the Company and, at the request and expense of the Company, they shall do all
        things necessary or desirable to enable the Company or its nominee to obtain for itself the full benefit of the know-how.</li>
    </ol>
    
    <p>The Employee shall at the request and expense of the Company do all things necessary or desirable to give effect to the rights of the Company to the know-how.</p>
    
    <p>Decisions as to the exploitation of the know-how and the intellectual property rights of the Company shall be at the sole discretion of the Company.</p>
    
    <u id="copyright"><b>Copyright and other intellectually property</b></u>
    
    <p>Any invention, discovery, process, design, plan, computer program,  or  any other intellectual property work whatever,
    and any modification, enhancement or development of any existing such thing (hereinafter referred to as “Inventions”) made or
    discovered by the Employee (whether alone or with others) in connection to employment,  during the course of the employment or
    other working hour which is in connection or relation to the business carried by the company , the company will be sole proprietor.</p>
    
    <p>As per this policy the employer has immediately agreed to disclose to the company of any such invention, improvement / modification
    in existing work, or other intellectual property, developed during the course of the employment.</p>
    
    <p>The employer agrees to appoint the company to be his attorney in their name and on behalf to execute any such documents or
    make application for patent, registration of property or other form of protection in name of the company in INDIA and such other
    countries, at the expenses of the company.</p>
    
    <p>Rights and obligation under this policy shall continue in fore even after termination f the policy in respect of intellectual
    property during the course of the employment of the employee under this policy and shall be binding upon his/her representative.</p>
    
    <u id="communication"><b>Communication and Review</b></u>
    <p>This policy will be communicated to staff via the Employee Handbook, during induction, and at staff meetings.</p>
    <p>This policy will be reviewed on a biennial basis.</p>

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
