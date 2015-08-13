<style>
    .col-1 {
        display: inline-block;
        margin: 0;
        padding: 0;
        width: 50px;
    }
</style>

<div id="siteSettingsWrapper" class="siteSettingsWrapper">
    <form class="form-horizontal" role="form" id="siteSettingsForm">
        <input type="hidden" name="siteID" id="siteID" value="<?php echo $data['site']->sites_id; ?>">
        <div class="optionPane">
            <h6>Free Website</h6>
            <div class="form-group">
                <label class="col-sm-3">Set Access URL</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="siteSettings_domain" name="siteSettings_domain" placeholder="<?php echo $this->lang->line('sitedata_label_domain_placeholder') ?>" value="<?php echo $data['site']->domain; ?>" <?php echo ($data['site']->domain) ? 'readonly=""' : ''; ?>>
                    <span id="publicURL"><?php echo ($data['site']->domain) ? 'Your web site url: http://' . $_SERVER['HTTP_HOST'] . '/'.$data['site']->domain : ''; ?></span>
                </div>
            </div>
        </div><!-- ./optionPane -->
    </form>
    <?php if(userdata( 'premium_domain' )!='inactive'):?>
    <div class="optionPane">
        <h6>Purchased Domain</h6>                
        <div class="product-purchased" id="domain-name">
            <form method="POST" name="quickbuy_domain" id="select-product" novalidate="novalidate">
                <input type="hidden" name="siteID" id="siteID" value="<?php echo $data['site']->sites_id; ?>">
                <input type="hidden" value="check_availability" name="action">
                <div class="dca-search form-group">
                    <label class="col-sm-3">Premium Domain</label>
                    <div class="col-sm-7">
                        <input type="text" required="" placeholder="Enter Keywords or Domain Names" id="domainname" name="domainname" autocomplete="off" class="form-control" value="<?php echo $data['site']->domainname; ?>" <?php echo ($data['site']->domainname) ? 'readonly=""' : ''; ?>>
                        <span id="remoteURL"><?php echo ($data['site']->domainname) ? 'Your web site url: http://' . $data['site']->domainname : ''; ?></span>
                    </div>
                    <button type="button" class="btn btn-primary btn-embossed col-sm-2" name="btn_check_availability" id="btn_check_availability">
                        Search
                    </button>
                    <div class="clearfix"></div>
                    
                    <div class="tld-container">
                        <div class="tld-container-primary" >
                            <span class="inline-block col-1"><input type="checkbox" value="com" id="com" name="tlds[]" ><label class="inline-block" for="com">com</label></span>
                            <span class="inline-block col-1"><input type="checkbox" value="net" id="net" name="tlds[]" ><label class="inline-block" for="net">net</label></span>
                            <span class="inline-block col-1"><input type="checkbox" value="org" id="org" name="tlds[]" ><label class="inline-block" for="org">org</label></span>
                            <span class="inline-block col-1"><input type="checkbox" value="biz" id="biz" name="tlds[]" ><label class="inline-block" for="biz">biz</label></span>
                            <span class="inline-block col-1"><input type="checkbox" value="in" id="in" name="tlds[]" ><label class="inline-block" for="in">in</label></span>
                            <span class="inline-block col-1"><input type="checkbox" value="club" id="club" name="tlds[]" ><label class="inline-block" for="club">club</label></span>
                            <span class="inline-block col-1"><input type="checkbox" value="desi" id="desi" name="tlds[]" ><label class="inline-block" for="desi">desi</label></span>
                            <span class="inline-block col-1"><input type="checkbox" value="guru" id="guru" name="tlds[]" ><label class="inline-block" for="guru">guru</label></span>
                            <span class="inline-block col-1"><input type="checkbox" value="xyz" id="xyz" name="tlds[]" ><label class="inline-block" for="xyz">xyz</label></span>
                            <span class="inline-block col-1"><a class="show-all-tlds inline-block " href="#">more</a></span>
                        </div>
                        <div class="tld-select" id="tld" style="display: block;clear:both;">
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="info" id="info" name="tlds[]"><label class="inline-block" for="info">info</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="us" id="us" name="tlds[]"><label class="inline-block" for="us">us</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="mobi" id="mobi" name="tlds[]"><label class="inline-block" for="mobi">mobi</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="asia" id="asia" name="tlds[]"><label class="inline-block" for="asia">asia</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="name" id="name" name="tlds[]"><label class="inline-block" for="name">name</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tel" id="tel" name="tlds[]"><label class="inline-block" for="tel">tel</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="co.in" id="co.in" name="tlds[]"><label class="inline-block" for="co.in">co.in</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tv" id="tv" name="tlds[]"><label class="inline-block" for="tv">tv</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="me" id="me" name="tlds[]"><label class="inline-block" for="me">me</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="ws" id="ws" name="tlds[]"><label class="inline-block" for="ws">ws</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="bz" id="bz" name="tlds[]"><label class="inline-block" for="bz">bz</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cc" id="cc" name="tlds[]"><label class="inline-block" for="cc">cc</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="net.in" id="net.in" name="tlds[]"><label class="inline-block" for="net.in">net.in</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="org.in" id="org.in" name="tlds[]"><label class="inline-block" for="org.in">org.in</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="ind.in" id="ind.in" name="tlds[]"><label class="inline-block" for="ind.in">ind.in</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="firm.in" id="firm.in" name="tlds[]"><label class="inline-block" for="firm.in">firm.in</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="gen.in" id="gen.in" name="tlds[]"><label class="inline-block" for="gen.in">gen.in</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="mn" id="mn" name="tlds[]"><label class="inline-block" for="mn">mn</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="us.com" id="us.com" name="tlds[]"><label class="inline-block" for="us.com">us.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="eu.com" id="eu.com" name="tlds[]"><label class="inline-block" for="eu.com">eu.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="uk.com" id="uk.com" name="tlds[]"><label class="inline-block" for="uk.com">uk.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="uk.net" id="uk.net" name="tlds[]"><label class="inline-block" for="uk.net">uk.net</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="gb.com" id="gb.com" name="tlds[]"><label class="inline-block" for="gb.com">gb.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="gb.net" id="gb.net" name="tlds[]"><label class="inline-block" for="gb.net">gb.net</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="de.com" id="de.com" name="tlds[]"><label class="inline-block" for="de.com">de.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cn.com" id="cn.com" name="tlds[]"><label class="inline-block" for="cn.com">cn.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="qc.com" id="qc.com" name="tlds[]"><label class="inline-block" for="qc.com">qc.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="kr.com" id="kr.com" name="tlds[]"><label class="inline-block" for="kr.com">kr.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="ae.org" id="ae.org" name="tlds[]"><label class="inline-block" for="ae.org">ae.org</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="br.com" id="br.com" name="tlds[]"><label class="inline-block" for="br.com">br.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="hu.com" id="hu.com" name="tlds[]"><label class="inline-block" for="hu.com">hu.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="jpn.com" id="jpn.com" name="tlds[]"><label class="inline-block" for="jpn.com">jpn.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="no.com" id="no.com" name="tlds[]"><label class="inline-block" for="no.com">no.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="ru.com" id="ru.com" name="tlds[]"><label class="inline-block" for="ru.com">ru.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="sa.com" id="sa.com" name="tlds[]"><label class="inline-block" for="sa.com">sa.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="se.com" id="se.com" name="tlds[]"><label class="inline-block" for="se.com">se.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="se.net" id="se.net" name="tlds[]"><label class="inline-block" for="se.net">se.net</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="uy.com" id="uy.com" name="tlds[]"><label class="inline-block" for="uy.com">uy.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="za.com" id="za.com" name="tlds[]"><label class="inline-block" for="za.com">za.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="co" id="co" name="tlds[]"><label class="inline-block" for="co">co</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="gr.com" id="gr.com" name="tlds[]"><label class="inline-block" for="gr.com">gr.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="pro" id="pro" name="tlds[]"><label class="inline-block" for="pro">pro</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="pw" id="pw" name="tlds[]"><label class="inline-block" for="pw">pw</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="sx" id="sx" name="tlds[]"><label class="inline-block" for="sx">sx</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="xxx" id="xxx" name="tlds[]"><label class="inline-block" for="xxx">xxx</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="net.au" id="net.au" name="tlds[]"><label class="inline-block" for="net.au">net.au</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="com.au" id="com.au" name="tlds[]"><label class="inline-block" for="com.au">com.au</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="com.co" id="com.co" name="tlds[]"><label class="inline-block" for="com.co">com.co</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="nom.co" id="nom.co" name="tlds[]"><label class="inline-block" for="nom.co">nom.co</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="net.co" id="net.co" name="tlds[]"><label class="inline-block" for="net.co">net.co</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="co.nz" id="co.nz" name="tlds[]"><label class="inline-block" for="co.nz">co.nz</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="net.nz" id="net.nz" name="tlds[]"><label class="inline-block" for="net.nz">net.nz</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="org.nz" id="org.nz" name="tlds[]"><label class="inline-block" for="org.nz">org.nz</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="in.net" id="in.net" name="tlds[]"><label class="inline-block" for="in.net">in.net</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tech" id="tech" name="tlds[]"><label class="inline-block" for="tech">tech</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="sale" id="sale" name="tlds[]"><label class="inline-block" for="sale">sale</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tours" id="tours" name="tlds[]"><label class="inline-block" for="tours">tours</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="golf" id="golf" name="tlds[]"><label class="inline-block" for="golf">golf</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="plus" id="plus" name="tlds[]"><label class="inline-block" for="plus">plus</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="site" id="site" name="tlds[]"><label class="inline-block" for="site">site</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="video" id="video" name="tlds[]"><label class="inline-block" for="video">video</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="com.de" id="com.de" name="tlds[]"><label class="inline-block" for="com.de">com.de</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="co.de" id="co.de" name="tlds[]"><label class="inline-block" for="co.de">co.de</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="la" id="la" name="tlds[]"><label class="inline-block" for="la">la</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="fish" id="fish" name="tlds[]"><label class="inline-block" for="fish">fish</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="associates" id="associates" name="tlds[]"><label class="inline-block" for="associates">associates</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="media" id="media" name="tlds[]"><label class="inline-block" for="media">media</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="singles" id="singles" name="tlds[]"><label class="inline-block" for="singles">singles</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="bike" id="bike" name="tlds[]"><label class="inline-block" for="bike">bike</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="vision" id="vision" name="tlds[]"><label class="inline-block" for="vision">vision</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="farm" id="farm" name="tlds[]"><label class="inline-block" for="farm">farm</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cab" id="cab" name="tlds[]"><label class="inline-block" for="cab">cab</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="domains" id="domains" name="tlds[]"><label class="inline-block" for="domains">domains</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="plumbing" id="plumbing" name="tlds[]"><label class="inline-block" for="plumbing">plumbing</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="clothing" id="clothing" name="tlds[]"><label class="inline-block" for="clothing">clothing</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="camera" id="camera" name="tlds[]"><label class="inline-block" for="camera">camera</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="estate" id="estate" name="tlds[]"><label class="inline-block" for="estate">estate</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="watch" id="watch" name="tlds[]"><label class="inline-block" for="watch">watch</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="academy" id="academy" name="tlds[]"><label class="inline-block" for="academy">academy</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="computer" id="computer" name="tlds[]"><label class="inline-block" for="computer">computer</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="world" id="world" name="tlds[]"><label class="inline-block" for="world">world</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="toys" id="toys" name="tlds[]"><label class="inline-block" for="toys">toys</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="enterprises" id="enterprises" name="tlds[]"><label class="inline-block" for="enterprises">enterprises</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="construction" id="construction" name="tlds[]"><label class="inline-block" for="construction">construction</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="contractors" id="contractors" name="tlds[]"><label class="inline-block" for="contractors">contractors</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="kitchen" id="kitchen" name="tlds[]"><label class="inline-block" for="kitchen">kitchen</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="land" id="land" name="tlds[]"><label class="inline-block" for="land">land</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="events" id="events" name="tlds[]"><label class="inline-block" for="events">events</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="marketing" id="marketing" name="tlds[]"><label class="inline-block" for="marketing">marketing</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="shoes" id="shoes" name="tlds[]"><label class="inline-block" for="shoes">shoes</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="builders" id="builders" name="tlds[]"><label class="inline-block" for="builders">builders</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="town" id="town" name="tlds[]"><label class="inline-block" for="town">town</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="training" id="training" name="tlds[]"><label class="inline-block" for="training">training</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="rentals" id="rentals" name="tlds[]"><label class="inline-block" for="rentals">rentals</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="productions" id="productions" name="tlds[]"><label class="inline-block" for="productions">productions</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="gripe" id="gripe" name="tlds[]"><label class="inline-block" for="gripe">gripe</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="bargains" id="bargains" name="tlds[]"><label class="inline-block" for="bargains">bargains</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="boutique" id="boutique" name="tlds[]"><label class="inline-block" for="boutique">boutique</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="coffee" id="coffee" name="tlds[]"><label class="inline-block" for="coffee">coffee</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="wtf" id="wtf" name="tlds[]"><label class="inline-block" for="wtf">wtf</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="fail" id="fail" name="tlds[]"><label class="inline-block" for="fail">fail</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="florist" id="florist" name="tlds[]"><label class="inline-block" for="florist">florist</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="camp" id="camp" name="tlds[]"><label class="inline-block" for="camp">camp</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="glass" id="glass" name="tlds[]"><label class="inline-block" for="glass">glass</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="repair" id="repair" name="tlds[]"><label class="inline-block" for="repair">repair</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="house" id="house" name="tlds[]"><label class="inline-block" for="house">house</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="solar" id="solar" name="tlds[]"><label class="inline-block" for="solar">solar</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="limited" id="limited" name="tlds[]"><label class="inline-block" for="limited">limited</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="community" id="community" name="tlds[]"><label class="inline-block" for="community">community</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="catering" id="catering" name="tlds[]"><label class="inline-block" for="catering">catering</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cards" id="cards" name="tlds[]"><label class="inline-block" for="cards">cards</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cheap" id="cheap" name="tlds[]"><label class="inline-block" for="cheap">cheap</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="zone" id="zone" name="tlds[]"><label class="inline-block" for="zone">zone</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cool" id="cool" name="tlds[]"><label class="inline-block" for="cool">cool</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="works" id="works" name="tlds[]"><label class="inline-block" for="works">works</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="vacations" id="vacations" name="tlds[]"><label class="inline-block" for="vacations">vacations</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="foundation" id="foundation" name="tlds[]"><label class="inline-block" for="foundation">foundation</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cleaning" id="cleaning" name="tlds[]"><label class="inline-block" for="cleaning">cleaning</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="care" id="care" name="tlds[]"><label class="inline-block" for="care">care</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="properties" id="properties" name="tlds[]"><label class="inline-block" for="properties">properties</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tools" id="tools" name="tlds[]"><label class="inline-block" for="tools">tools</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="industries" id="industries" name="tlds[]"><label class="inline-block" for="industries">industries</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="parts" id="parts" name="tlds[]"><label class="inline-block" for="parts">parts</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="services" id="services" name="tlds[]"><label class="inline-block" for="services">services</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="exchange" id="exchange" name="tlds[]"><label class="inline-block" for="exchange">exchange</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="digital" id="digital" name="tlds[]"><label class="inline-block" for="digital">digital</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="direct" id="direct" name="tlds[]"><label class="inline-block" for="direct">direct</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="place" id="place" name="tlds[]"><label class="inline-block" for="place">place</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="deals" id="deals" name="tlds[]"><label class="inline-block" for="deals">deals</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cash" id="cash" name="tlds[]"><label class="inline-block" for="cash">cash</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="discount" id="discount" name="tlds[]"><label class="inline-block" for="discount">discount</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="fitness" id="fitness" name="tlds[]"><label class="inline-block" for="fitness">fitness</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="church" id="church" name="tlds[]"><label class="inline-block" for="church">church</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="life" id="life" name="tlds[]"><label class="inline-block" for="life">life</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="guide" id="guide" name="tlds[]"><label class="inline-block" for="guide">guide</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="gifts" id="gifts" name="tlds[]"><label class="inline-block" for="gifts">gifts</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="immo" id="immo" name="tlds[]"><label class="inline-block" for="immo">immo</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="money" id="money" name="tlds[]"><label class="inline-block" for="money">money</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="lease" id="lease" name="tlds[]"><label class="inline-block" for="lease">lease</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="ventures" id="ventures" name="tlds[]"><label class="inline-block" for="ventures">ventures</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="holdings" id="holdings" name="tlds[]"><label class="inline-block" for="holdings">holdings</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="codes" id="codes" name="tlds[]"><label class="inline-block" for="codes">codes</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="limo" id="limo" name="tlds[]"><label class="inline-block" for="limo">limo</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="viajes" id="viajes" name="tlds[]"><label class="inline-block" for="viajes">viajes</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="diamonds" id="diamonds" name="tlds[]"><label class="inline-block" for="diamonds">diamonds</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="voyage" id="voyage" name="tlds[]"><label class="inline-block" for="voyage">voyage</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="careers" id="careers" name="tlds[]"><label class="inline-block" for="careers">careers</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="recipes" id="recipes" name="tlds[]"><label class="inline-block" for="recipes">recipes</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="university" id="university" name="tlds[]"><label class="inline-block" for="university">university</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="dating" id="dating" name="tlds[]"><label class="inline-block" for="dating">dating</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="partners" id="partners" name="tlds[]"><label class="inline-block" for="partners">partners</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="holiday" id="holiday" name="tlds[]"><label class="inline-block" for="holiday">holiday</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="financial" id="financial" name="tlds[]"><label class="inline-block" for="financial">financial</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="expert" id="expert" name="tlds[]"><label class="inline-block" for="expert">expert</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cruises" id="cruises" name="tlds[]"><label class="inline-block" for="cruises">cruises</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="flights" id="flights" name="tlds[]"><label class="inline-block" for="flights">flights</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="villas" id="villas" name="tlds[]"><label class="inline-block" for="villas">villas</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="clinic" id="clinic" name="tlds[]"><label class="inline-block" for="clinic">clinic</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="surgery" id="surgery" name="tlds[]"><label class="inline-block" for="surgery">surgery</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="dental" id="dental" name="tlds[]"><label class="inline-block" for="dental">dental</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tienda" id="tienda" name="tlds[]"><label class="inline-block" for="tienda">tienda</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="condos" id="condos" name="tlds[]"><label class="inline-block" for="condos">condos</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="maison" id="maison" name="tlds[]"><label class="inline-block" for="maison">maison</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="capital" id="capital" name="tlds[]"><label class="inline-block" for="capital">capital</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="engineering" id="engineering" name="tlds[]"><label class="inline-block" for="engineering">engineering</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="finance" id="finance" name="tlds[]"><label class="inline-block" for="finance">finance</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="insure" id="insure" name="tlds[]"><label class="inline-block" for="insure">insure</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="claims" id="claims" name="tlds[]"><label class="inline-block" for="claims">claims</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="coach" id="coach" name="tlds[]"><label class="inline-block" for="coach">coach</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="memorial" id="memorial" name="tlds[]"><label class="inline-block" for="memorial">memorial</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tax" id="tax" name="tlds[]"><label class="inline-block" for="tax">tax</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="fund" id="fund" name="tlds[]"><label class="inline-block" for="fund">fund</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="furniture" id="furniture" name="tlds[]"><label class="inline-block" for="furniture">furniture</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="healthcare" id="healthcare" name="tlds[]"><label class="inline-block" for="healthcare">healthcare</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="restaurant" id="restaurant" name="tlds[]"><label class="inline-block" for="restaurant">restaurant</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="pizza" id="pizza" name="tlds[]"><label class="inline-block" for="pizza">pizza</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="legal" id="legal" name="tlds[]"><label class="inline-block" for="legal">legal</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="delivery" id="delivery" name="tlds[]"><label class="inline-block" for="delivery">delivery</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="email" id="email" name="tlds[]"><label class="inline-block" for="email">email</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="reisen" id="reisen" name="tlds[]"><label class="inline-block" for="reisen">reisen</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="equipment" id="equipment" name="tlds[]"><label class="inline-block" for="equipment">equipment</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="gallery" id="gallery" name="tlds[]"><label class="inline-block" for="gallery">gallery</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="graphics" id="graphics" name="tlds[]"><label class="inline-block" for="graphics">graphics</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="lighting" id="lighting" name="tlds[]"><label class="inline-block" for="lighting">lighting</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="center" id="center" name="tlds[]"><label class="inline-block" for="center">center</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="management" id="management" name="tlds[]"><label class="inline-block" for="management">management</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="systems" id="systems" name="tlds[]"><label class="inline-block" for="systems">systems</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="photography" id="photography" name="tlds[]"><label class="inline-block" for="photography">photography</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="company" id="company" name="tlds[]"><label class="inline-block" for="company">company</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="solutions" id="solutions" name="tlds[]"><label class="inline-block" for="solutions">solutions</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tips" id="tips" name="tlds[]"><label class="inline-block" for="tips">tips</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="support" id="support" name="tlds[]"><label class="inline-block" for="support">support</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="today" id="today" name="tlds[]"><label class="inline-block" for="today">today</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="technology" id="technology" name="tlds[]"><label class="inline-block" for="technology">technology</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="directory" id="directory" name="tlds[]"><label class="inline-block" for="directory">directory</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="photos" id="photos" name="tlds[]"><label class="inline-block" for="photos">photos</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="international" id="international" name="tlds[]"><label class="inline-block" for="international">international</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="agency" id="agency" name="tlds[]"><label class="inline-block" for="agency">agency</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="report" id="report" name="tlds[]"><label class="inline-block" for="report">report</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="city" id="city" name="tlds[]"><label class="inline-block" for="city">city</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="education" id="education" name="tlds[]"><label class="inline-block" for="education">education</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="institute" id="institute" name="tlds[]"><label class="inline-block" for="institute">institute</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="exposed" id="exposed" name="tlds[]"><label class="inline-block" for="exposed">exposed</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="supplies" id="supplies" name="tlds[]"><label class="inline-block" for="supplies">supplies</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="supply" id="supply" name="tlds[]"><label class="inline-block" for="supply">supply</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="gratis" id="gratis" name="tlds[]"><label class="inline-block" for="gratis">gratis</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="schule" id="schule" name="tlds[]"><label class="inline-block" for="schule">schule</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="business" id="business" name="tlds[]"><label class="inline-block" for="business">business</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="network" id="network" name="tlds[]"><label class="inline-block" for="network">network</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="menu" id="menu" name="tlds[]"><label class="inline-block" for="menu">menu</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="uno" id="uno" name="tlds[]"><label class="inline-block" for="uno">uno</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="buzz" id="buzz" name="tlds[]"><label class="inline-block" for="buzz">buzz</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="blue" id="blue" name="tlds[]"><label class="inline-block" for="blue">blue</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="kim" id="kim" name="tlds[]"><label class="inline-block" for="kim">kim</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="pink" id="pink" name="tlds[]"><label class="inline-block" for="pink">pink</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="red" id="red" name="tlds[]"><label class="inline-block" for="red">red</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="shiksha" id="shiksha" name="tlds[]"><label class="inline-block" for="shiksha">shiksha</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="build" id="build" name="tlds[]"><label class="inline-block" for="build">build</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="sc" id="sc" name="tlds[]"><label class="inline-block" for="sc">sc</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="vc" id="vc" name="tlds[]"><label class="inline-block" for="vc">vc</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="dance" id="dance" name="tlds[]"><label class="inline-block" for="dance">dance</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="democrat" id="democrat" name="tlds[]"><label class="inline-block" for="democrat">democrat</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="wiki" id="wiki" name="tlds[]"><label class="inline-block" for="wiki">wiki</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="ninja" id="ninja" name="tlds[]"><label class="inline-block" for="ninja">ninja</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="immobilien" id="immobilien" name="tlds[]"><label class="inline-block" for="immobilien">immobilien</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="futbol" id="futbol" name="tlds[]"><label class="inline-block" for="futbol">futbol</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="social" id="social" name="tlds[]"><label class="inline-block" for="social">social</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="reviews" id="reviews" name="tlds[]"><label class="inline-block" for="reviews">reviews</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="bid" id="bid" name="tlds[]"><label class="inline-block" for="bid">bid</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="webcam" id="webcam" name="tlds[]"><label class="inline-block" for="webcam">webcam</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="trade" id="trade" name="tlds[]"><label class="inline-block" for="trade">trade</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="ink" id="ink" name="tlds[]"><label class="inline-block" for="ink">ink</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="jobs" id="jobs" name="tlds[]"><label class="inline-block" for="jobs">jobs</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="co.com" id="co.com" name="tlds[]"><label class="inline-block" for="co.com">co.com</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="pub" id="pub" name="tlds[]"><label class="inline-block" for="pub">pub</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="host" id="host" name="tlds[]"><label class="inline-block" for="host">host</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="press" id="press" name="tlds[]"><label class="inline-block" for="press">press</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="website" id="website" name="tlds[]"><label class="inline-block" for="website">website</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="rest" id="rest" name="tlds[]"><label class="inline-block" for="rest">rest</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="bar" id="bar" name="tlds[]"><label class="inline-block" for="bar">bar</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="pictures" id="pictures" name="tlds[]"><label class="inline-block" for="pictures">pictures</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="investments" id="investments" name="tlds[]"><label class="inline-block" for="investments">investments</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="credit" id="credit" name="tlds[]"><label class="inline-block" for="credit">credit</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="accountants" id="accountants" name="tlds[]"><label class="inline-block" for="accountants">accountants</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="loans" id="loans" name="tlds[]"><label class="inline-block" for="loans">loans</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="creditcard" id="creditcard" name="tlds[]"><label class="inline-block" for="creditcard">creditcard</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="moda" id="moda" name="tlds[]"><label class="inline-block" for="moda">moda</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="kaufen" id="kaufen" name="tlds[]"><label class="inline-block" for="kaufen">kaufen</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="consulting" id="consulting" name="tlds[]"><label class="inline-block" for="consulting">consulting</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="global" id="global" name="tlds[]"><label class="inline-block" for="global">global</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="vegas" id="vegas" name="tlds[]"><label class="inline-block" for="vegas">vegas</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="luxury" id="luxury" name="tlds[]"><label class="inline-block" for="luxury">luxury</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="actor" id="actor" name="tlds[]"><label class="inline-block" for="actor">actor</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="rocks" id="rocks" name="tlds[]"><label class="inline-block" for="rocks">rocks</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="haus" id="haus" name="tlds[]"><label class="inline-block" for="haus">haus</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="london" id="london" name="tlds[]"><label class="inline-block" for="london">london</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="career" id="career" name="tlds[]"><label class="inline-block" for="career">career</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="attorney" id="attorney" name="tlds[]"><label class="inline-block" for="attorney">attorney</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="lawyer" id="lawyer" name="tlds[]"><label class="inline-block" for="lawyer">lawyer</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="cooking" id="cooking" name="tlds[]"><label class="inline-block" for="cooking">cooking</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="country" id="country" name="tlds[]"><label class="inline-block" for="country">country</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="fishing" id="fishing" name="tlds[]"><label class="inline-block" for="fishing">fishing</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="horse" id="horse" name="tlds[]"><label class="inline-block" for="horse">horse</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="rodeo" id="rodeo" name="tlds[]"><label class="inline-block" for="rodeo">rodeo</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="vodka" id="vodka" name="tlds[]"><label class="inline-block" for="vodka">vodka</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="link" id="link" name="tlds[]"><label class="inline-block" for="link">link</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="pics" id="pics" name="tlds[]"><label class="inline-block" for="pics">pics</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="sexy" id="sexy" name="tlds[]"><label class="inline-block" for="sexy">sexy</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="diet" id="diet" name="tlds[]"><label class="inline-block" for="diet">diet</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="help" id="help" name="tlds[]"><label class="inline-block" for="help">help</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="gift" id="gift" name="tlds[]"><label class="inline-block" for="gift">gift</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="hiphop" id="hiphop" name="tlds[]"><label class="inline-block" for="hiphop">hiphop</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="christmas" id="christmas" name="tlds[]"><label class="inline-block" for="christmas">christmas</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="guitars" id="guitars" name="tlds[]"><label class="inline-block" for="guitars">guitars</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tattoo" id="tattoo" name="tlds[]"><label class="inline-block" for="tattoo">tattoo</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="hosting" id="hosting" name="tlds[]"><label class="inline-block" for="hosting">hosting</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="property" id="property" name="tlds[]"><label class="inline-block" for="property">property</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="photo" id="photo" name="tlds[]"><label class="inline-block" for="photo">photo</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="audio" id="audio" name="tlds[]"><label class="inline-block" for="audio">audio</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="blackfriday" id="blackfriday" name="tlds[]"><label class="inline-block" for="blackfriday">blackfriday</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="juegos" id="juegos" name="tlds[]"><label class="inline-block" for="juegos">juegos</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="click" id="click" name="tlds[]"><label class="inline-block" for="click">click</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="ooo" id="ooo" name="tlds[]"><label class="inline-block" for="ooo">ooo</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tokyo" id="tokyo" name="tlds[]"><label class="inline-block" for="tokyo">tokyo</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="auction" id="auction" name="tlds[]"><label class="inline-block" for="auction">auction</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="forsale" id="forsale" name="tlds[]"><label class="inline-block" for="forsale">forsale</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="quebec" id="quebec" name="tlds[]"><label class="inline-block" for="quebec">quebec</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="space" id="space" name="tlds[]"><label class="inline-block" for="space">space</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="durban" id="durban" name="tlds[]"><label class="inline-block" for="durban">durban</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="capetown" id="capetown" name="tlds[]"><label class="inline-block" for="capetown">capetown</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="joburg" id="joburg" name="tlds[]"><label class="inline-block" for="joburg">joburg</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="beer" id="beer" name="tlds[]"><label class="inline-block" for="beer">beer</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="surf" id="surf" name="tlds[]"><label class="inline-block" for="surf">surf</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="casa" id="casa" name="tlds[]"><label class="inline-block" for="casa">casa</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="work" id="work" name="tlds[]"><label class="inline-block" for="work">work</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="green" id="green" name="tlds[]"><label class="inline-block" for="green">green</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="energy" id="energy" name="tlds[]"><label class="inline-block" for="energy">energy</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="tires" id="tires" name="tlds[]"><label class="inline-block" for="tires">tires</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="wang" id="wang" name="tlds[]"><label class="inline-block" for="wang">wang</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="degree" id="degree" name="tlds[]"><label class="inline-block" for="degree">degree</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="engineer" id="engineer" name="tlds[]"><label class="inline-block" for="engineer">engineer</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="software" id="software" name="tlds[]"><label class="inline-block" for="software">software</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="market" id="market" name="tlds[]"><label class="inline-block" for="market">market</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="mortgage" id="mortgage" name="tlds[]"><label class="inline-block" for="mortgage">mortgage</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="dentist" id="dentist" name="tlds[]"><label class="inline-block" for="dentist">dentist</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="flowers" id="flowers" name="tlds[]"><label class="inline-block" for="flowers">flowers</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="wedding" id="wedding" name="tlds[]"><label class="inline-block" for="wedding">wedding</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="garden" id="garden" name="tlds[]"><label class="inline-block" for="garden">garden</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="fashion" id="fashion" name="tlds[]"><label class="inline-block" for="fashion">fashion</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="soy" id="soy" name="tlds[]"><label class="inline-block" for="soy">soy</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="fit" id="fit" name="tlds[]"><label class="inline-block" for="fit">fit</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="black" id="black" name="tlds[]"><label class="inline-block" for="black">black</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="adult" id="adult" name="tlds[]"><label class="inline-block" for="adult">adult</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="porn" id="porn" name="tlds[]"><label class="inline-block" for="porn">porn</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="شبكة" id="شبكة" name="tlds[]"><label class="inline-block" for="شبكة">شبكة</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="移动" id="移动" name="tlds[]"><label class="inline-block" for="移动">移动</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="中文网" id="中文网" name="tlds[]"><label class="inline-block" for="中文网">中文网</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="在线" id="在线" name="tlds[]"><label class="inline-block" for="在线">在线</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="संगठन" id="संगठन" name="tlds[]"><label class="inline-block" for="संगठन">संगठन</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="机构" id="机构" name="tlds[]"><label class="inline-block" for="机构">机构</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="орг" id="орг" name="tlds[]"><label class="inline-block" for="орг">орг</label>
                            </span>
                            <span class="inline-block col-sm-2">
                                <input type="checkbox" value="भारत" id="भारत" name="tlds[]"><label class="inline-block" for="भारत">भारत</label>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
            <div id="domain_result" class="results-wrapper" style="display: none">
                <h6>Search Results <span id="plan_error" class="error hide">Please select a domain name</span></h6>
                <form method="POST" name="buy_domain" id="book-domain-form" novalidate="novalidate" action="<?php echo site_url('domain/bookDomain/' . $data['site']->sites_id); ?>">
                    <div class="search-results-container table-responsive">

                    </div>
                </form>
            </div>
        </div>
    </div><!-- ./optionPane -->
    <?php endif;?>
</div><!-- /.siteSettingsWrapper -->
<script>
    $(document).ready(function() {
        $('#siteSettings_domain').keyup(function(e) {
            if ($(this).prop("readonly")) {
                e.preventDefault();
                return false;
            }
            if (/^[a-z0-9]{3,}$/i.test($(this).val())) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo site_url('sites/checkDomain') ?>",
                    data: {domain: $(this).val().toLowerCase()},
                    success: function(res) {
                        if (res.error == 0) {
                            $('#publicURL').text(res.errorMessage).css('color', 'green');
                        }
                        if (res.error == 1) {
                            $('#publicURL').text(res.errorMessage).css('color', 'red');
                        }
                    },
                    dataType: "JSON",
                    async: false
                });
            } else {
                $('#publicURL').text('Domain names can only contain letters and numbers').css('color', 'red');
            }
        });
        
        $( "#tld" ).hide();
        $( ".show-all-tlds" ).click(function() {
            var lable = $(this).text();
            if(lable=='more'){
                $(this).text('less');
            }else{
                $(this).text('more');
            }
            $( "#tld" ).toggle();
        });
        $('#btn_check_availability').click(function(){
            var checked = false;
            $('.tld-container input[type=checkbox]').each(function(){
                if($(this).is(":checked")){
                    checked = true;
                }
            });
            if(!checked){
                $('.tld-container-primary input[type=checkbox]').each(function(){
                    $( this ).prop( "checked", true );
                });
            }
            $.ajax({
                url: "<?php echo site_url('domain/checkDomainAvalability') ?>",
                type: 'post',
                data: $('#select-product').serialize(),
                success:function(ret){
                    $('.search-results-container').html(ret);
                    $('#domain_result').show();
                    $('#domainSubmittButton').removeAttr('disabled');
                }
            }).done(function(){

            });
        });
    });
</script>