import AppHeaderBrand from '@/components/app/header/appUserHeaderBrand';
import AppUserHeaderNav from "@/components/app/header/appUserHeaderNav";
import AppUserHeaderLogout from '@/components/app/header/appUserHeaderLogout';

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
