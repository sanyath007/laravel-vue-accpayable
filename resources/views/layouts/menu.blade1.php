<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Accounts Payable System</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">หน้าหลัก</a></li>

                @if (!Auth::guest())
        
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                          รายการใช้รถ
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a href="{{ url('/reserve/calendar') }}">ตารางใช้รถวันนี้</a></li>
                          <li><a href="{{ url('/reserve/list') }}">รายการขอใช้รถ</a></li>
                          <li><a href="{{ url('/reserve/new') }}">บันทึกขอใช้รถ</a></li>
                          <!-- <li><a href="{{ url('/reserve/cancel') }}">ยกเลิกการขอใช้รถ</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a href="{{ url('/pos') }}">รายการรออนุมัติ</a></li> -->
                        </ul>
                    </li>

                    @if (Auth::user()->person_id == '1300200009261')
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              พนักงานขับรถ
                              <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                              <li><a href="{{ url('/assign/list') }}">รายการจัดรถ</a></li>
                              <li><a href="{{ url('/assign/new') }}">บันทึกการจัดรถ</a></li>
                              <li><a href="{{ url('/assign/drive') }}">รายการวิ่งรถ</a></li>
                              <!-- <li><a href="{{ url('/reserve/calendar') }}">ตารางทำงาน พขร.</a></li> -->
                              <!-- <li><a href="{{ url('/reserve/new') }}">บันทึกขอใช้รถ</a></li>
                              <li><a href="{{ url('/reserve/cancel') }}">ยกเลิกการขอใช้รถ</a></li>
                              <li role="separator" class="divider"></li>
                              <li><a href="{{ url('/pos') }}">รายการรออนุมัติ</a></li> -->
                            </ul>
                        </li>

                     @endif

                    @if (Auth::user()->person_id == '1300200009261')

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                ทะเบียน
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/tax/list') }}">รายการต่อภาษี</a></li>
                                <li><a href="{{ url('/insurance/list') }}">รายการต่อประกันภัย</a></li>
                                <li><a href="{{ url('/fuel/list') }}">รายการใช้น้ำมันเชื้อเพลิง</a></li>
                            </ul>
                        </li>

                    @endif

                    @if (Auth::user()->person_id == '1300200009261')
                       
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              บำรุงรักษารถ
                              <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                              <li><a href="{{ url('/maintained/list') }}">ประวัติการบำรุงรักษารถ</a></li>
                              <li><a href="{{ url('/maintained/accident') }}">ประวัติการเกิดอุบัติเหตุรถ</a></li>
                              <!-- <li><a href="#">ขอสนับสนุนจ้างซ่อมบำรุง</a></li> -->
                              <li role="separator" class="divider"></li>
                              <li><a href="{{ url('/maintained/checklist') }}">การตรวจเช็ครถประจำเดือน</a></li>
                              <!-- <li><a href="#">Separated link</a></li>
                              <li role="separator" class="divider"></li>
                              <li><a href="#">One more separated link</a></li> -->
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                              ข้อมูลพื้นฐาน
                              <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                              <li><a href="{{ url('/creditor/list') }}">รายการเจ้าหนี้</a></li>
                              <li><a href="{{ url('/creditor-prefix/list') }}">ประเภทคำนำหน้า</a></li>
                              <!-- <li role="separator" class="divider"></li>
                              <li><a href="#">ประเภทรถ</a></li>
                              <li><a href="#">ชนิดรถ</a></li>
                              <li role="separator" class="divider"></li>
                              <li><a href="#">ผู้จัดจำหน่าย</a></li>
                              <li><a href="#">อู่ซ่อมรถ</a></li> -->
                            </ul>
                        </li>

                    @endif

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                          รายงาน
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a href="{{ url('/report/reserve') }}">รายงานการขอใช้รถ</a></li>
                          <li><a href="{{ url('/report/drive') }}">รายงานการเดินรถ</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ url('/report/service') }}">รายงานการให้บริการทั้งหมด</a></li>
                          <li><a href="{{ url('/report/period') }}">รายงานการให้บริการ ตามช่วงเวลา</a></li>
                          <li><a href="{{ url('/report/depart') }}">รายงานการให้บริการ ตามหน่วยงาน</a></li>
                          <!-- <li><a href="{{ url('/report/calendar') }}">สถิติการเดินรถ แยกตามสถานที่</a></li>
                          <li><a href="{{ url('/report/calendar') }}">สถิติการเดินรถ แยกตาม พขร.</a></li> -->
                        </ul>
                    </li>

                @endif

            </ul>
      
            <ul class="nav navbar-nav navbar-right">

                @if (Auth::guest())

                    <li><a href="{{ url('/auth/login') }}">Login</a></li>
                    <li><a href="{{ url('/auth/register') }}">Register</a></li>

                @else

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          {{ Auth::user()->person_firstname }} {{ Auth::user()->person_lastname }}
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>

                @endif

            </ul>
        </div>
    </div>
</nav>
