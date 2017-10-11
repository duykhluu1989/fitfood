@extends('beta.layouts.main')

@section('content')

    @include('beta.layouts.partials.menu')

    @include('beta.layouts.partials.header', ['banner' => asset('assets/images/page-header/faq.jpg'), 'title' => 'Chính Sách Vận Chuyển & Giao Hàng'])

    <div class="container">
        <div class="row">
            <div id="primary" class="full-width row">
                <div id="content" class="box-shadow">
                    <div class="wrap-faq">

                        @include('beta.layouts.partials.language')

                        <div class="page-title">
                            <h2>Chính Sách Vận Chuyển & Giao Hàng</h2>
                        </div>

                        <p>Ch&iacute;nh s&aacute;ch vận chuyển: Fitfood giao h&agrave;ng giới hạn một số quận tại TP.HCM. Th&ocirc;ng tin chi tiết về thời gian v&agrave; chi ph&iacute; giao h&agrave;ng được quy định như khung b&ecirc;n dưới.</p>
                        <p>Ch&uacute; &yacute;:&nbsp;&nbsp; Ph&iacute; giao h&agrave;ng = ng&agrave;y ăn thực tế x ph&iacute; giao h&agrave;ng tr&ecirc;n 1 ng&agrave;y</p>
                        <table width="600">
                            <tbody>
                            <tr>
                                <td width="148">
                                    <p><strong>Khu vực giao h&agrave;ng</strong></p>
                                </td>
                                <td width="150">
                                    <p><strong>&nbsp;Ph&iacute; ship tr&ecirc;n 1 tuần </strong></p>
                                </td>
                                <td width="302">
                                    <p><strong>Khung thời gian giao h&agrave;ng</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 1</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;Miễn ph&iacute;</p>
                                </td>
                                <td width="302">
                                    <p>8:00 - 8:30<br /> 8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 2: Chỉ khu vực Thảo Điền v&agrave; Mai Ch&iacute; Thọ</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75,000</p>
                                </td>
                                <td width="302">
                                    <p>9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 3</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;Miễn ph&iacute;</p>
                                </td>
                                <td width="302">
                                    <p>8:00 - 8:30<br /> 8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 4</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;Miễn ph&iacute;</p>
                                </td>
                                <td width="302">
                                    <p>8:00 - 8:30<br /> 8:30 - 9:00<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 5</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 50,000</p>
                                </td>
                                <td width="302">
                                    <p>8:00 - 8:30<br /> 8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 6</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75,000</p>
                                </td>
                                <td width="302">
                                    <p>8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 7</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 50,000</p>
                                </td>
                                <td width="302">
                                    <p>8:00 - 8:30<br /> 8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 8</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75,000</p>
                                </td>
                                <td width="302">
                                    <p>8:00 - 8:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 10</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 50,000</p>
                                </td>
                                <td width="302">
                                    <p>8:00 - 8:30<br /> 8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Quận 11</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 50,000</p>
                                </td>
                                <td width="302">
                                    <p>8:00 - 8:30<br /> 8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>Ph&uacute; Nhuận</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 50,000</p>
                                </td>
                                <td width="302">
                                    <p>8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>B&igrave;nh Thạnh</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 50,000</p>
                                </td>
                                <td width="302">
                                    <p>8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>T&acirc;n B&igrave;nh</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75,000</p>
                                </td>
                                <td width="302">
                                    <p>8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>T&acirc;n Ph&uacute;</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75,000</p>
                                </td>
                                <td width="302">
                                    <p>8:30 - 9:00<br /> 9:00 - 9:30<br /> 9:30 - 10:00<br /> 10:00 - 10:30<br /> 10:30 - 11:00<br /> Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="148">
                                    <p>G&ograve; Vấp</p>
                                </td>
                                <td width="150">
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 75,000</p>
                                </td>
                                <td width="302">
                                    <p>Tối h&ocirc;m trước (19:00 - 22:00)</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p>&nbsp;</p>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop