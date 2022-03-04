<form method="get" action="{{ url($address) }}">
    <div class="row">
    @if (!isset($hide_zone) && (Auth::user()->usertype == 'admin' || isset($show_zone)))
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="zone" id="zone_filter" class="form-control hide-print" >
                <option value="" selected >~ዞባ ምረፅ~</option>
                <!-- <option value="0" 
                    @if ($zoneCode == '0')
                        {{ 'selected' }}
                    @endif 
                    >ኩሎም</option> -->
                @foreach ($zobadatas as $key => $value)
                    <option value="{{ $key }}" 
                    @if ($zoneCode == $key)
                        {{ 'selected' }}
                    @endif 
                    >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    @endif
    @if(!isset($hide_woreda) && (array_search(Auth::user()->usertype, ['admin', 'zone','zoneadmin']) !== false || isset($show_woreda)))
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="woreda" id="woreda_filter" class="form-control hide-print">
                <option value="" selected >~ወረዳ ምረፅ~</option>
                @foreach ($filter['woreda_l'] as $key => $value)
                    <option value="{{ $key }}" 
                    @if ($filter['woreda'] && $filter['woreda']->woredacode == $key)
                        {{ 'selected' }}
                    @endif 
                    >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    @endif
    @if(!isset($hide_tabia))
    <div class="col-md-2 col-sm-4 col-xs-4">
        <select name="tabia" id="tabia_filter" class="form-control hide-print" >
            <option value="" selected >~ጣብያ ምረፅ~</option>
            @foreach ($filter['tabia_l'] as $key => $value)
                <option value="{{ $key }}" 
                @if ($filter['tabia'] && $filter['tabia']->tabiaCode == $key)
                    {{ 'selected' }}
                @endif 
                >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    @endif
    @if(!isset($hide_widabe))
    <div class="col-md-2 col-sm-4 col-xs-4">
        <select name="widabe" id="widabe_filter" class="form-control hide-print" >
            <option value="" selected >~መሰረታዊ ውዳበ ምረፅ~</option>
            @foreach ($filter['widabe_l'] as $key => $value)
                <option value="{{ $key }}" 
                @if ($filter['widabe'] && $filter['widabe']->widabeCode == $key)
                    {{ 'selected' }}
                @endif 
                >{{ $value }}</option>
            @endforeach
        </select>
    </div>
    @endif
    @if(!isset($hide_wahio))
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="wahio" id="wahio_filter" class="form-control hide-print" >
                <option value="" selected >~ዋህዮ ምረፅ~</option>
                @foreach ($filter['wahio_l'] as $key => $value)
                    <option value="{{ $key }}" 
                    @if ($filter['wahio'] && $filter['wahio']->id == $key)
                        {{ 'selected' }}
                    @endif 
                    >{{ $value }}</option>
                @endforeach
            </select>
        </div>
    @endif
    @if(isset($show_actions))
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="general" id="general" class="form-control hide-print">
                <option value="" selected>~ሓፈሻዊ ተግባር~</option>
                <option value="{{ App\Constant::CREATE}}" 
                @if ($filter['general'] && $filter['general'] == App\Constant::CREATE)
                    {{ 'selected' }}
                @endif 
                >ምዝገባ</option>
                <option value="{{ App\Constant::UPDATE}}"
                @if ($filter['general'] && $filter['general'] == App\Constant::UPDATE)
                    {{ 'selected' }}
                @endif 
                >ምምሕያሽ</option>
                <option value="{{ App\Constant::DELETE}}"
                @if ($filter['general'] && $filter['general'] == App\Constant::DELETE)
                    {{ 'selected' }}
                @endif 
                >ምስራዝ</option>
            </select>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="specific" id="specific" class="form-control hide-print">
                <option value="" selected>~ፉሉይ ተግባር~</option>
                @foreach (App\Constant::ACTION_MAP as $key => $value)
                <option value="{{ $key }}" 
                @if ($filter['specific'] && $filter['specific'] == $key)
                    {{ 'selected' }}
                @endif 
                >{{ $value }}</option>
            @endforeach
            </select>
        </div>
    @endif
    @if(!isset($show_month) && !isset($show_year))
        <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
    @endif
    </div>
    @if(isset($show_month) || isset($show_year))
    <div class="row" style="margin-top: 15px;">
    @if(isset($show_month))
     <div class="col-md-2 col-sm-4 col-xs-4">
        <select name="month" id="month" class="form-control hide-print">
            <option value="" selected >~ወርሒ~</option>
            <option value="1">መስከረም</option>
            <option value="2">ጥቅምቲ</option>
            <option value="3">ሕዳር</option>
            <option value="4">ታሕሳስ</option>
            <option value="5">ጥሪ</option>
            <option value="6">ለካቲት</option>
            <option value="7">መጋቢት</option>
            <option value="8">ሚያዝያ</option>
            <option value="9">ግንቦት</option>
            <option value="10">ሰነ</option>
            <option value="11">ሓምለ</option>
            <option value="12">ነሓሰ</option>
        </select>
      </div>
    @endif
    @if(isset($show_year))
    <div class="col-md-2 col-sm-4 col-xs-4">
        <input name="year" id="year" class="form-control" placeholder="ዓመተምህረት"
        @if (isset($year))
            value="{{ $year }}"
        @endif 
        >
    </div>
    @endif
    @if(isset($paid_or_not))
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="paid" id="paid" class="form-control hide-print">
                <option value="" selected >~ዝኸፈሉ/ዘይኸፈሉ~</option>
                <option value="0">ዘይኸፈሉ</option>
                <option value="1">ዝኸፈሉ</option>
            </select>
        </div>
    @endif
    @if(isset($show_rank))
        <div class="col-md-2 col-sm-4 col-xs-4">
            <select name="rank" id="rank" class="form-control hide-print">
                <option value="" selected>~ደረጃ ስርርዕ~</option>
                <option>ቅድሚት</option>
                <option>ማእኸላይ</option>
                <option>ድሕሪት</option>
            </select>
        </div>
    @endif
    <button class="btn btn-success hide-print" type="submit">ኣርእይ</button>
    </div>
    @endif
</form>