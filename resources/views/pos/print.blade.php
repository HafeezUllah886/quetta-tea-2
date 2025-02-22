<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS Bill</title>
    <style>
        body{
            background: rgb(232, 232, 232);
            font-size: 15px;
            font-family: "Helvetica";
        }
        .main{
            width: 50mm;
            background: #fff;
            overflow: hidden;
            margin: 0px auto;
            padding: 10px;
        }
        .logo{
            width: 100%;
            overflow: hidden;
            height: 130px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo img{
            width:80%;
        }
        .header p{
            margin: 2px 0px;
        }
        .content{
            overflow: hidden;
            width: 100%;
        }
        .content table{
            width: 100%;
            border-collapse: collapse;
        }

        .bg-dark{
            background: black;
            color:#ffff;
        }

        .text-left{
            text-align: left !important;
        }
        .text-right{
            text-align: right !important;
        }
        .text-center{
            text-align: center !important;
        }
        .area-title{

            font-size: 18px;
        }
        tr.bottom-border {
            border-bottom: 1px solid #ccc; /* Add a 1px solid border at the bottom of rows with the "my-class" class */
        }
        .uppercase{
            text-transform: uppercase;
        }
        .bordered-tb{
            border-top: 3px dotted #000000;
            border-bottom: 3px dotted #000000;
        }
    </style>
</head>
<body>
    <div class="main" id="main">
        <div >
            {{-- <img style="margin:0 auto;height:200px;" src="{{ asset('assets/images/logo.png') }}" alt=""> --}}
            <h2 class="text-center" style="margin: 1px">{{projectNameAuth()}}</h2>
            <h3 class="text-center" style="margin: 0">Airport Road, Quetta</h3>
            <h5 class="text-center" style="margin: 0">+92 999 9999999</h5>
         </div>
        <div class="header">
          
            <div class="area-title">
                <p class="text-center bordered-tb" style="font-weight:bold">POS Receipt</p>
            </div>
            <table>
                <tr>
                    <td width="20%">B# </td>
                    <td width="15%"> {{ $bill->id }}</td>
                    <td width="15%">Date: </td>
                    <td width="50%"> {{ date("d-m-Y", strtotime($bill->date)) }}</td>
                </tr> 
            </table>
            <table>
                <tr>
                    <td width="15%"> Waiter: </td>
                    <td colspan="3">
                        {{ $bill->waiter->name }}
                    </td>
                   
                </tr>
                <tr>
                    <td width="15%"> Table: </td>
                    <td colspan="3">
                        @if($bill->type == "Dine-In")
                        {{ $bill->table->name }}
                        @else
                        {{$bill->type}}
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div class="content">
            <table>
                <thead class="bordered-tb">
                    <th class="text-left">Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Amount</th>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $items = 0;
                        $qty = 0;
                    @endphp
                   @foreach ($bill->details as $item)
                   @php
                       $total += $item->amount;
                       $items += 1;
                       $qty += $item->qty;
                   @endphp
                            <tr>
                                <td colspan="4" class="uppercase">{{ $item->size->item->name }}</td>
                            </tr>
                            <tr class="bottom-border">
                                <td>{{ $item->size->title }} |</td>
                                <td>{{ $item->qty }} |</td>
                                <td>{{ number_format($item->price, 0) }} |</td>
                                <td class="text-right">{{ number_format($item->amount ,0)}}</td>
                            </tr>
                   @endforeach
                   <tr>
                    <td colspan="3">
                        Item(s): {{ $items }} |
                        Qty: {{ $qty }}
                    </td>
                    <td class="text-right" style="font-size: 18px"><strong>{{ number_format($total,0) }}</strong></td>
                   </tr>
                   <tr>
                    <td colspan="3" class="text-right"> <strong>Discount</strong></td>
                    <td class="text-right" style="font-size: 18px"> <strong>{{number_format($bill->discount,0)}}</strong> </td>
                   </tr>
                   <tr>
                    <td colspan="3" class="text-right"> <strong>Payable</strong></td>
                    <td class="text-right" style="font-size: 18px"> <strong>{{number_format($total - $bill->discount,0)}}</strong> </td>
                   </tr>

                </tbody>
            </table>
        </div>
        {{-- <div class="footer">
            <hr>
            <h5 class="text-center">Developed by Nexgen Pakistan, Quetta <br> 0331-0070041</h5>
        </div> --}}
    </div>
</body>

</html>
<script src="{{ asset('src/plugins/src/jquery-ui/jquery-ui.min.js') }}"></script>
 <script>
setTimeout(function() {
    window.print();
    }, 2000);

</script> 
