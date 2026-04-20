import AppHeaderBrand from '@/components/app/header/app-user-header-brand';
import AppHeaderSidebar from '@/components/app/header/app-user-header-sidebar';

export default () => (
    <div className="header">
        <div className="container">
            <div className="table">
                <div className="tr">
                    <div className="td left">
                        <AppHeaderBrand/>
                    </div>
                    <div className="td center">

                    </div>
                    <div className="td right">
                        <AppHeaderSidebar/>
                    </div>
                </div>
            </div>
            <div className="clear"></div>
        </div>
    </div>
);
