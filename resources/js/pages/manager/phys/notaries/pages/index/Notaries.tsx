import { TNotary } from './types';
import { TPaginated } from '@/types/types';
import Notary from './Notary';
import Pagination from "@/components/app/manager/common/pagination/Pagination";

type TProps = {
    notaries: TPaginated<TNotary>;
};

export default function ({ notaries } : TProps) {
    return (
        <div className={'notaries'}>
            {notaries.data.length ? (
                <>
                    <div className="table">
                        <div className="tr tr-default">
                            <div className="th align-center">ФИО</div>
                            <div className="th align-center">Адрес</div>
                            <div className="th align-center">Телефон</div>
                            <div className="th align-center">E-mails</div>
                            <div className="th align-center">Комментарий</div>
                            <div className="th edit"></div>
                        </div>
                        {notaries.data.map((notary, index) => <Notary key={index} notary={notary}/>)}
                    </div>
                    <Pagination links={notaries.links}/>
                </>
            ) : <div>Нотариусов не найдено</div>}
        </div>
    )
}
