<?php
$my_email = "registration@ccaconference.net";
$errors = array();

// Remove $_COOKIE elements from $_REQUEST.
if(count($_COOKIE)){foreach(array_keys($_COOKIE) as $value){unset($_REQUEST[$value]);}}

// Check referrer is from same site.
if(!(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && stristr($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']))){$errors[] = "You must enable referrer logging to use the form";}

// Display any errors and exit if errors exist.
if(count($errors)){foreach($errors as $value){print "$value<br>";} exit;}
if(!defined("PHP_EOL")){define("PHP_EOL", strtoupper(substr(PHP_OS,0,3) == "WIN") ? "\r\n" : "\n");}

// Build message.
function build_message($request_input){
  if(!isset($message_output)){
    $message_output ="";
  }
  if(!is_array($request_input)){
    $message_output = $request_input;
  }else{
    foreach($request_input as $key => $value){
      if(!empty($value)){
        if(!is_numeric($key)){
          $message_output .= str_replace("_"," ",ucfirst($key)).": ".build_message($value).PHP_EOL.PHP_EOL;
        }else{
          $message_output .= build_message($value).", ";
        }
      }
    }
  }
  return rtrim($message_output,", ");
}

// Defining the Variables

$date = date("Y-m-d,h_i_s A");

$message = build_message($_REQUEST);

$message = 'Dear Colleague,

Thank you for registering for CCA 2017. If you have requested any official letters, please allow up to 5 business days to receive your documents.

If you are an author, please make sure to send us your camera ready version and a signed copyright form via email to info@ccaconference.net. You can find the copyright form here: www.ccaconference.net/papers. Please note that failing to do so may result in an unsuccessful process of your registration.

You can find your registration details below. If there are any errors in the information you have provided, please write an email to us at registration@ccaconference.net mentioning the correct information. Please note that you SHOULD NOT refill the form.

---

' . $message;

$message = $message . 'File uploaded: ';

$message = $message . $date.'_'.$_FILES['file']['name'];

$message = $message . PHP_EOL.PHP_EOL."-- ".PHP_EOL."";

$message = stripslashes($message);

$subject = "Registration Details for " . $_REQUEST['Email'];

$headers = "From: " . $_REQUEST['Email'];

$your_email = $_REQUEST['Email'];

$your_subject = "Your Registration Details for CCA'17";

$your_headers = "From: CCA'17 <" . $my_email . ">";

if ((($_FILES["file"]["type"] == "image/gif")

|| ($_FILES["file"]["type"] == "image/jpeg")

|| ($_FILES["file"]["type"] == "image/png")

|| ($_FILES["file"]["type"] == "image/jpg")

|| ($_FILES["file"]["type"] == "image/tif"))

&& ($_FILES["file"]["size"] < 20000000))

  {

  if ($_FILES["file"]["error"] > 0)

    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
      move_uploaded_file($_FILES["file"]["tmp_name"],"receipts/" . $_FILES["file"]["name"]);
      rename("receipts/".$_FILES['file']['name'],"receipts/".$date.'_'.$_FILES['file']['name']);
  $filename = $date.'_'.$_FILES['file']['name'];
    }
  }
else
  {
  die("The file you have selected for upload is invalid. <br />
  Please make sure the file you are trying to upload is an image (.jpg, .jpeg, .png, .gif, .tif) <br />
  No other file types are allowed.");
  }

mail($my_email,$subject,$message,$headers);
mail($your_email,$your_subject,$message,$your_headers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noarchive">
<meta name="description" content="">
<meta name="keywords" content="cloud services, iaas, paas, saas, cloud infrastructures, cloud computing, storage, data architectures, distributed networking, computing, cloud management, cloud operations, security and privary, performance, scalability, reliability, virtualization, cloud data analytics, big data management, big data analysis, cloud software, hardware, cloud applications, social clouds systems, mobile clouds systems, cloud economics, Big Data Management, Big Data Analysis, Cloud Applications, Cloud Computing, Cloud Data Analytics, Cloud Economics, Cloud Infrastructures, Cloud Management, Cloud Operations, Cloud Services, Cloud Software and Hardware, Data Architectures, Distributed Networking and Computing, IaaS, PaaS, SaaS, Performance, Reliability, Scalability, Security and Privary, Social and Mobile Clouds Systems, Storage, Virtualization, Cloud as a Service, Infrastructure as a service (IaaS), Platform as a service (PaaS) and Cloud Foudry, Software as a service (SaaS), Storage as a service, Network as a service, Information as a service, Cloud Infrastructure, Cloud Computing Architectures, Storage ad Data Architectures, Distributed and Cloud Networking, Infrastructure Technologies, Public, Private, and Hybrid Clouds, Cloud Management and Operations, Cloud Composition, Federation, Bridging, and Bursting, Cloud Migration, Hybrid Cloud Integration, Compliance Management in Cloud, Green and Energy Management of Cloud Computing, Cloud Configuration and Capacity Management, Cloud Workload Profiling and Deployment Control, Selfservice Cloud Portal, Dashboard, and Analytics, Cloud Metering and Monitoring, Service management automation, Cloud Security, Data Privacy, Cloud Privacy, Security as a service, Performance, scalability, and reliability, Performance of cloud systems and applications, Cloud Availability and Reliability, Microservices based architecture, Systems software and hardware, Virtualization and Composition, Cloud Provisioning Orchestration, Architecture support for cloud computing, Data Analytics in Cloud, Analytics Applications, Scientific Computing and Data Management, Big data management and analytics, Storage, Data, and Analytics Clouds, Software Eng. Practice for Cloud, Cloud Solution Design Patterns, Cloud Programming Models, Cloud Development Tools, Service Life Cycle Manageme, Autonomic Business Process and Workflow Management in Clouds, Cloud Modeling, Cloud Applications, Large Scale Cloud Application, Innovative Cloud Applications and Experiences, Social, and Mobile Clouds, Cloud Economics, Cloud Strategy for Enterprise Business Transformation, Cloud Service Level Agreement (SLA), Economic, Business Model of Cloud, ROI Analysis, Cloud Quality Management, Cloud Computing Consulting, Cloud Cost and Pricing, Services Science, Data as a Service, Cloud Operations and Analytics, Mobile Cloud Computing, Edge Cloud and Fog Computing, Service Modelling and Analytics, Cloud Computing Fundamentals, Cloud Computing Platforms and Applications, Cloud Computing Enabling Technology, Architecture and Virtualization, Intercloud architecture models, Cloud services delivery models, campus integration and “last mile” issues, Networking technologies, Programming models and systems/tools, Cloud system design with FPGAs, GPUs, APUs, Storage and file systems, Scalability and performance, Resource provisioning, monitoring, management and maintenance, Operational, economic and business models, Green data centers, Computational resources, storage and network virtualization, Resource monitoring, Virtual desktops, Resilience, fault tolerance, disaster recovery, Modeling and performance evaluation, Disaster recovery, Energy efficiency, Cloud Services and Applications, Cloud services models and frameworks, Cloud services reference models and standardization, Cloud­powered services design, Business processes, compliance and certification, Data management applications and services, Application workflows and scheduling, Application benchmarks and use cases, Cloud­based services and protocols, Fault­tolerance and availability of cloud services and applications, Application development and debugging tools, Business models and economics of cloud services, Internet of Things (IoT) and Mobile on Cloud, IoT cloud architectures and models, Cloud­based dynamic composition of IoT, Cloud­based context­aware IoT, Mobile cloud architectures and models, Green mobile cloud computing, Resource management in mobile cloud environments, Cloud support for mobility­aware networking protocols, Multimedia applications in mobile cloud environments, Cloud­based mobile networks and applications, Big Data, Machine learning, Data mining, Approximate and scalable statistical methods, Graph algorithms, Querying and search, Data lifecycle management, Frameworks, tools and their composition, Dataflow management and scheduling, High Performance Computing (HPC) in/with the Cloud, Load balancing, Middleware solutions, Scalable scheduling, HPC as a Service, Programming models, Use cases and experience reports, Cloud deployment systems, TCO analysis Cloud vs HPC, Security and Privacy, Accountability and audit, Authentication and authorization, Cloud integrity, Cryptography for and in the cloud, Hypervisor security, Identity management and security as a service, Prevention of data loss or leakage, Secure, interoperable identity management, Trust and credential management, Trusted computing, Usable security, Distributed Cloud / Cloud Brokering / Edge Computing, Distributed Cloud Infrastructure, Cloud federation and hybrid cloud infrastructure, Utility Computing (UC), Cloud Brokering Problem, Edge Computing infrastructure, Cloudlets, Fog Computing Systems, Big Data Management, Business Process Management and Services, Cloud Computing Business Models, Cloud Interoperability and Federation, Cloud Services Management and Composition, Dynamic and Adaptive Services, Economic and Business Models for Services, Enterprise Architecture and Services, Energy Issues in Clouds, Identity and Access Management using Services, Service Composition, Service Governance, Service Marketplaces, Services Life-Cycles, Agile Computing, Architectural Models for Cloud Computing, Big Data Management, Frameworks for Building Service Based Applications, Mashups, Model-Driven Service Engineering, Self-Organizing Service-Oriented and Cloud Architectures, Service Quality and Service Interface Design Guidelines, Services Security and Privacy, IoT Services and IoT Clouds, Mobile Clouds and Mobile Services, Compliance, Self-Organizing Services and Clouds, Service Modeling, Analysis, and Design, Service Science, Verification, Crowdsourcing Business Services, Service-Oriented Business Collaboration, Social and Crowd-based Cloud, DevOps in the Cloud, Emerging Trends in Storage, Computation and Network Clouds, Next Generation Services Middleware and Service Repositories, RESTful Clouds and Services, Commerce, Energy, Finance, Health, Scientific Computing, Smart Cities, Telecom, Cloudenabled Manufacturing System, Cloudenabled Wireless Body Area Networks, Cloudenabled Internet of Vehicles, Administration and Manageability, Distributed and Parallel Query Processing, Distributed and Cloud Networking, Storage Architectures, Privacy, security, ownership and reliability issues, Dynamic resource provisioning, Roaming services in Clouds, Agentbased Cloud Computing, Cloudbased Innovative applications, Virtualization management operations /discovery, configuration, provisioning, performance, CLOUD: Cloud computing, Cloud economics, Core cloud services, Cloud technologies, Cloud computing, On-demand computing models, Hardware-as-a-service, Software-as-a-service [SaaS applications], Platform-as-service, Storage as a service in cloud, Data-as-a-Service, Service-oriented architecture (SOA), Cloud computing programming and application development, Scalability, discovery of services and data in Cloud computing infrastructures, Trust and clouds, Client-cloud computing challenges, Geographical constraints for deploying clouds, CLOUD: Challenging features, Privacy, security, ownership and reliability issues, Performance and QoS, Dynamic resource provisioning, Power-efficiency and Cloud computing, Load balancing, Application streaming, Cloud SLAs, business models and pricing policies, Cloud service subscription model, Cloud standardized SLA, Cloud-related privacy, Cloud-related control, Managing applications in the clouds, Mobile clouds, Roaming services in Clouds, Agent-based Cloud Computing, Cloud brokering, Cloud contracts (machine readable), Cloud security, CLOUD: Platforms, Infrastructures and Applications, Custom platforms, Large-scale compute infrastructures, Data centers, Processes intra- and inter-clouds, Content and service distribution in Cloud computing infrastructures, Multiple applications can run on one computer (virtualization a la VMWare), Grid computing (multiple computers can be used to run one application), Cloud-computing vendor governance and regulatory compliance, Enterprise clouds, Enterprise-centric cloud computing, Interaction between vertical clouds, Public, Private, and Hybrid clouds, Cloud computing testbeds, GRID: Grid networks, services and applications, GRID theory, frameworks, methodologies, architecture, ontology, GRID infrastructure and technologies, GRID middleware; GRID protocols and networking, GRID computing, utility computing, autonomic computing, metacomputing, Programmable GRID, Data GRID, Context ontology and management in GRIDs, Distributed decisions in GRID networks, GRID services and applications, Virtualization, modeling, and metadata in GRID, Resource management, scheduling, and scalability in GRID, GRID monitoring, control, and management, Traffic and load balancing in GRID, User profiles and priorities in GRID, Performance and security in GRID systems, Fault tolerance, resilience, survivability, robustness in GRID, QoS/SLA in GRID networks; GRID fora, standards, development, evolution, GRID case studies, validation testbeds, prototypes, and lessons learned, VIRTUALIZATION: Computing in virtualization-based environments, Principles of virtualization, Virtualization platforms, Thick and thin clients, Data centers and nano-centers, Open virtualization format, Orchestration of virtualization across data centers, Dynamic federation of compute capacity, Dynamic geo-balancing, Instant workload migration, Virtualization-aware storage, Virtualization-aware networking, Virtualization embedded-software-based smart mobile phones, Trusted platforms and embedded supervisors for security, Virtualization management operations /discovery, configuration, provisioning, performance, etc., Energy optimization and saving for green datacenters, Virtualization supporting cloud computing, Applications as pre-packaged virtual machines, Licensing and support policies, Biometrics Technologies, Cloud Engineering, Cloud Security, Computer Architecture and Design, Data Compression, Data Management in Mobile Networks, Distributed and Parallel Applications, E-Commerce Security, Embedded Systems and Software, Fuzzy and Neural Network Systems, Information Content Security, Mobile Networking, Mobility and Nomadicity, Multimedia Computing, Real-Time Systems, Signal Processing, Pattern Recognition and Applications, User Interfaces, Visualization and Modeling, Web Services Security, Wireless Sensor Networks, Cloud Computing, Cloud Gaming, Computational Intelligence, Cryptography and Data Protection, Data Embedding and Watermarking, Data Stream Processing in Mobile/Sensor Networks, E-Business, E-Learning, Forensics, Recognition Technologies and Applications, Image Processing, Information and Data Management, Mobile, Ad Hoc and Sensor Network Management, Network Security, Semantic Web and Ontologies, User Interface and Usability Issues for Mobile Applications, Web Services Architecture, Modeling and Design, Wireless Communications, E-Technology, Cloud computing conference, Cloud computing conference 2017">
<title>CCA'17 - Registration Form Filled!</title>

<meta name="handheldfriendly" content="true">
<meta name="mobileoptimized" content="240">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="../css/ffhmt.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic|Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<!--[if IE-9]><html lang="en" class="ie9"><![endif]-->

<script src="../js/modernizr.custom.63321.js"></script>
<script>
  (function() {
    var cx = '016656741306535874023:gclrredrpsi';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
</head>

<body>
<nav id="slide-menu">
  <h1>CCA'17</h1>
  <ul>
    <li><a href="/">Home</a></li>
    <li><a href="../papers">Paper Submissions</a></li>
    <li><a href="../program">Program</a></li>
    <li><a href="../dates">Important Dates</a></li>
    <li><a href="../registration">Registration</a></li>
    <li><a href="../committee">Committee</a></li>
    <li><a href="../keynote">Keynotes</a></li>
    <li><a href="../sponsor">Sponsors</a></li>
    <li><a href="../venue">Venue</a></li>
    <li><a href="../accommodation">Accommodation</a></li>
    <li><a href="../symposium">Symposiums</a></li>
    <li><a href="#contact">Contact Us</a></li>
  </ul>
</nav>

<div id="content">
  <div class="desktop">
  <div class="cbp-af-header">
  <div class="cbp-af-inner">
    <a href="/"><img src="../img/logo.png" class="flex-logo"></a>
      <nav>
        <a href="/">Home</a><p class="dot">&middot;</p><a href="../papers">Paper Submission</a><p class="dot">&middot;</p><a href="../program">Program</a><p class="dot">&middot;</p><a href="../dates">Important Dates</a><p class="dot">&middot;</p><a href="../registration">Registration</a><p class="dot">&middot;</p><a href="../committee">Committee</a><p class="dot">&middot;</p><a href="../keynote">Keynotes</a><p class="dot">&middot;</p><a href="../sponsor">Sponsors</a><p class="dot">&middot;</p><a href="../venue">Venue</a><p class="dot">&middot;</p><a href="../accommodation">Accommodation</a><p class="dot">&middot;</p><a href="../symposium">Symposiums</a><p class="dot">&middot;</p><a href="#contact">Contact Us</a>
    </nav>
  </div>
</div>
</div>

  <header>
    <div class="mobile">
      <div class="cbp-af-header">
  <div class="cbp-af-inner">
    <div class="unit unit-s-3-4 unit-m-1-3 unit-l-1-3">
          <a href="/"><img src="../img/logo.png" class="flex-logo"></a>
      </div>
      <div class="unit unit-s-1-3 unit-m-2-3 unit-m-2-3-1 unit-l-2-3">
          <div class="menu-trigger"></div>
      </div>
  </div>
</div>
        <div class="bg">
          <h1>International Conference on Cloud<br>Computing and Applications (CCA'17)</h1>
          <p class="subhead">June 5 - 6, 2017 | Rome, Italy</p>

          <a href="../papers" class="bg-link">Paper Submission</a> <p class="dot">&middot;</p> <a href="../dates" class="bg-link">Important Dates</a> <p class="dot">&middot;</p> <a href="../registration" class="bg-link">Registration</a>

        <div class="searchbox grid">
        <div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
          <div class="unit unit-s-1 unit-m-1-4-2 unit-l-1-4-2">
            <p class="body">Search:</p> 
          </div>
 <div class="unit unit-s-3-4 unit-m-3-4 unit-l-3-4">
        <gcse:searchbox-only resultsUrl="../results"></gcse:searchbox-only>
  </div>
</div>
</div>
        </div>
    </div>

    <div class="desktop">
      <div class="grid">
        <div class="unit unit-s-1 unit-m-1 unit-l-1">
        <div class="bg-img">
          <img src="../img/header.jpg" class="flex-img" alt="Header">
        </div>

        <div class="bg">
          <h1>International Conference on Cloud<br>Computing and Applications (CCA'17)</h1>
          <p class="subhead">June 5 - 6, 2017 | Rome, Italy</p>

          <a href="../papers" class="bg-link">Paper Submission</a> <p class="dot">&middot;</p> <a href="../dates" class="bg-link">Important Dates</a> <p class="dot">&middot;</p> <a href="../registration" class="bg-link">Registration</a>

        <div class="searchbox grid">
        <div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
          <div class="unit unit-s-1 unit-m-1-4-2 unit-l-1-4-2">
            <p class="body">Search:</p> 
          </div>
 <div class="unit unit-s-3-4 unit-m-3-4 unit-l-3-4">
        <gcse:searchbox-only resultsUrl="../results"></gcse:searchbox-only>
  </div>
</div>
</div>
        </div>
        </div> 
      </div>
    </div>
  </header>

  <div class="grid main-content">
  <div class="unit unit-s-1 unit-m-1-3-1 unit-l-1-3-1">
    <div class="unit-spacer">
      <h2>Announcements</h2>
      <div id="main-slider" class="liquid-slider">
    <div>
      <h2 class="title">1</h2>
      <p class="bold">CCA 2017:</p>
      <p class="body">CCA 2017 will  be held in Rome, Italy on June 5 - 6, 2017.</p>
<!-- 
      <p class="bold">Poster Board Dimensions:</p>
      <p class="body">Authors presenting via poster boards are to be informed that poster boards are 110 cm height and 80 cm width.</p> -->
    </div>          
    <div>
      <h2 class="title">2</h2>
      <p class="bold">Best Paper Award:</p>
      <p class="body">Two best paper awards will be conferred to author(s) of the papers that receive the highest rank during the peer-review and by the respected session chairs. Please visit <a href="../papers" class="body-link">Paper Submission</a> for more information.</p>
    </div>
    <div>
      <h2 class="title">3</h2>
      <p class="bold">Propose Exhibits, Workshops & More</p>
      <p class="body">CCA attracts a wide range of researchers in the field of nanotechnology. As a prominent company in the field of nanotechnology, we would like to offer you an exhibit at CCA. Please visit <a href="../events" class="body-link">Events</a> for more information.</p>
    </div>

  </div>

    </div>
  </div>

<div class="unit unit-s-1 unit-m-1-4-1 unit-l-1-4-1">
  <div class="unit-spacer content">
    <p class="body">Thank you for filling out the registration form. You should receive an email with your information. Please keep this email for your reference.</p>

    <p class="body">If you do not receive an email, <strong>please check your SPAM folder</strong>.</p>

  <p class="body">If you have requested any official invitation letters, please allow up to 5 business days to receive your documents.</p> 

    <p class="body">If there are any problems in the information you have filled out, please write an email to us at <a href="mailto:registration@ccaconference.net" class="body-link">registration@ccaconference.net</a> mentioning the mistakes made. Please note that you SHOULD NOT refill the form.</p>

  <p class="body">We are looking forward to seeing you at CCA'17!</p>
  </div>
</div>

  <div class="unit unit-s-1 unit-m-1-3-1 unit-l-1-3-1">
  <div class="unit-spacer">
    <section class="main">
        <div class="custom-calendar-wrap">
          <div id="custom-inner" class="custom-inner">
            <div class="custom-header clearfix">
              <nav>
                <span id="custom-prev" class="custom-prev"></span>
                <span id="custom-next" class="custom-next"></span>
              </nav>
              <h2 id="custom-month" class="custom-month"></h2>
              <h3 id="custom-year" class="custom-year"></h3>
            </div>
            <div id="calendar" class="fc-calendar-container"></div>
          </div>
        </div>
      </section>
    <h2>Upcoming Dates</h2>

<div class="grid events">
<div class="unit unit-s-1 unit-m-1-4 unit-l-1-4">
  <div class="date">
    Dec. 1, 2016
  </div>
</div>

<div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
  <div class="unit-spacer">
    Paper Submission Deadline
  </div>
</div>
</div>

<div class="grid events">
<div class="unit unit-s-1 unit-m-1-4 unit-l-1-4">
  <div class="date">
    Feb. 15, 2017
  </div>
</div>

<div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
  <div class="unit-spacer">
    Notification of Authors
  </div>
</div>
</div>

<div class="grid events">
<div class="unit unit-s-1 unit-m-1-4 unit-l-1-4">
  <div class="date">
    Mar. 1, 2017
  </div>
</div>

<div class="unit unit-s-1 unit-m-3-4 unit-l-3-4">
  <div class="unit-spacer">
    Final Version of Extended Abstract or Paper Submission Deadline
  </div>
</div>
</div>

  </div>
  </div>
</div>

<footer id="contact">
  <div class="grid">
  <div class="unit unit-s-1 unit-m-1-3 unit-l-1-3">
  <div class="unit-spacer">
    <h2>Contact Us</h2>
    <p class="body">International ASET Inc.<br>
    Unit No. 417, 1376 Bank St.<br>
    Ottawa, Ontario, Canada<br>
    Postal Code: K1H 7Y3<br>
    +1-613-695-3040<br>
    <a href="mailto:info@ccaconference.net">info@ccaconference.net</a></p>
    </div>
  </div>

  <div class="unit unit-s-1 unit-m-2-3 unit-l-2-3 contact">
  <div class="unit-spacer">
  <p class="body">For questions or comments regarding CCA'17, please fill out the form below:</p>

    <form action="../contactus.php" method="post" enctype="multipart/form-data" name="ContactForm">
  
  <table border="0" class="contact">
    <tbody>
      <tr>
        <td class="label">Name:</td>
        <td class="text"><span id="sprytextfield1">
              <input name="Name" type="text" id="Name" size="40" autocomplete="off">

              <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        </tr>

        <tr>
            <td class="label">Email:</td>
            <td class="text"><span id="sprytextfield2">
            <input name="Email" type="text" id="Email" size="40" autocomplete="off">
            <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
          </tr>

          <tr>
            <td class="label">Confirm Email:</td>
             <td class="text"><span id="spryconfirm4">
              <input name="Confirm Email" type="text" id="Confirm Email" size="40" autocomplete="off">
              <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">Emails don't match.</span></span></td>
          </tr>

          <tr>
            <td class="label">Subject:</td>
            <td class="text"><span id="sprytextfield3">
              <input name="Subject" type="text" id="Subject" size="40" autocomplete="off">
              <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          </tr>

          <tr>
            <td valign="top" class="label">Message:</td>
            <td class="text"><span id="sprytextarea1">
              <textarea name="Message" id="Message" cols="31" rows="10" autocomplete="off"></textarea>
              <span class="textareaRequiredMsg">A value is required.</span></span>
              <center>
        <input type="submit" name="Submit" value="Submit" accept="image/jpeg">
        <input type="reset" name="Reset" value="Reset"></center></td>
          </tr>

        </tbody></table><br>

        
</form>
    </div>
  </div>
  </div>
</footer> 

<div class="copyright">
  <a href="http://international-aset.com">International ASET Inc.</a> | <a href="http://http://international-aset.com/phplistpublic/?p=subscribe&id=1">Subscribe</a> | <a href="../terms">Terms of Use</a> | <a href="../sitemap">Sitemap</a>
  <p class="body">&copy; Copyright International ASET Inc., 2016. All rights reserved.</p>
  <p class="copyright1">Have any feedback? Please provide them here: <script>var refURL = window.location.protocol + "//" + window.location.host + window.location.pathname; document.write('<a href="http://http://international-aset.com/feedback/?refURL=' + refURL+'" class="body-link">Feedback</a>');</script></p>
</div>
</div>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="../js/jquery.nicescroll.min.js"></script>
  <script type="text/javascript" src="../js/jquery.calendario.js"></script>
    <script type="text/javascript" src="../js/data.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
  <script src="../js/jquery.liquid-slider.min.js"></script>  
  <script src="../js/classie.js"></script>
    <script src="../js/cbpAnimatedHeader.min.js"></script>
    <script src="../js/SpryValidationSelect.js" type="text/javascript"></script>

    <script src="../js/SpryValidationTextField.js" type="text/javascript"></script>

    <script src="../js/SpryValidationConfirm.js" type="text/javascript"></script>

    <script src="../js/SpryValidationCheckbox.js" type="text/javascript"></script>
    <script src="../js/SpryValidationTextarea.js" type="text/javascript"></script>

    <script type="text/javascript">
/*
  Slidemenu
*/
(function() {
  var $body = document.body
  , $menu_trigger = $body.getElementsByClassName('menu-trigger')[0];

  if ( typeof $menu_trigger !== 'undefined' ) {
    $menu_trigger.addEventListener('click', function() {
      $body.className = ( $body.className == 'menu-active' )? '' : 'menu-active';
    });
  }

}).call(this);
</script>

    <script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {isRequired:false});

var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");

var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");

var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");

var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");

var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {invalidValue:"-1"});

var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "email");

var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");

var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3", {invalidValue:"-1", isRequired:false});

var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "date", {format:"mm/dd/yyyy"});

var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1");
</script>


    <script type="text/javascript"> 
      $(function() {
      
        var transEndEventNames = {
            'WebkitTransition' : 'webkitTransitionEnd',
            'MozTransition' : 'transitionend',
            'OTransition' : 'oTransitionEnd',
            'msTransition' : 'MSTransitionEnd',
            'transition' : 'transitionend'
          },
          transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
          $wrapper = $( '#custom-inner' ),
          $calendar = $( '#calendar' ),
          cal = $calendar.calendario( {
            onDayClick : function( $el, $contentEl, dateProperties ) {

              if( $contentEl.length > 0 ) {
                showEvents( $contentEl, dateProperties );
              }

            },
            caldata : codropsEvents,
            displayWeekAbbr : true
          } ),
          $month = $( '#custom-month' ).html( cal.getMonthName() ),
          $year = $( '#custom-year' ).html( cal.getYear() );

        $( '#custom-next' ).on( 'click', function() {
          cal.gotoNextMonth( updateMonthYear );
        } );
        $( '#custom-prev' ).on( 'click', function() {
          cal.gotoPreviousMonth( updateMonthYear );
        } );

        function updateMonthYear() {        
          $month.html( cal.getMonthName() );
          $year.html( cal.getYear() );
        }

        // just an example..
        function showEvents( $contentEl, dateProperties ) {

          hideEvents();
          
          var $events = $( '<div id="custom-content-reveal" class="custom-content-reveal"><h4>Events for ' + dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year + '</h4></div>' ),
            $close = $( '<span class="custom-content-close"></span>' ).on( 'click', hideEvents );

          $events.append( $contentEl.html() , $close ).insertAfter( $wrapper );
          
          setTimeout( function() {
            $events.css( 'top', '0%' );
          }, 25 );

        }
        function hideEvents() {

          var $events = $( '#custom-content-reveal' );
          if( $events.length > 0 ) {
            
            $events.css( 'top', '100%' );
            Modernizr.csstransitions ? $events.on( transEndEventName, function() { $( this ).remove(); } ) : $events.remove();

          }

        }
      
      });
    </script>

        <script>
    $('#main-slider').liquidSlider();
  </script>
  <script>
(function($){
        $(window).load(function(){
            $("html").niceScroll();
        });
    })(jQuery);
</script>
</body>
</html>
