import AppHeaderBrand from '@manager/components/appUserHeaderBrand';
import AppUserHeaderNav from "@manager/components/appUserHeaderNav";
import AppUserHeaderLogout from '@manager/components/appUserHeaderLogout';

export default () => (
    <div className="header">
        <div className="container">
            <div className="table">
                <div className="tr">
                    <div className="td left">
                        <AppHeaderBrand/>
                    </div>
                    <div className="td center">
                        <AppUserHeaderNav/>
                    </div>
                    <div className="td right">
                        <AppUserHeaderLogout/>
                    </div>
                </div>
            </div>
            <div className="clear"></div>
        </div>
    </div>
);
